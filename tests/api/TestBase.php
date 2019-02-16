<?php
/**
 * --------------------------------------------------------------------------------------------------------------------
 * <copyright company="Aspose">
 *   Copyright (c) 2018 Aspose.Slides for Cloud
 * </copyright>
 * <summary>
 *   Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 * 
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 * 
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *  SOFTWARE.
 * </summary>
 * --------------------------------------------------------------------------------------------------------------------
 */

namespace Aspose\Slides\Cloud\Sdk\Tests\Api;

use Aspose\Storage\Api\StorageApi;
use Aspose\Storage\Model\Requests\PutCreateRequest;
use Aspose\Storage\Model\Requests\DeleteFileRequest;
use Aspose\Slides\Cloud\Sdk\Api\Configuration;
use Aspose\Slides\Cloud\Sdk\Tests\Utils\TestUtils;

class TestBase extends \PHPUnit_Framework_TestCase
{
    protected $storage;
    protected $config;
    protected $values;
    protected $okToFailValues;

    protected function setUp()
    {
        $this->config = new Configuration();
        $testConfig = \GuzzleHttp\json_decode(file_get_contents(realpath(__DIR__."/../../testConfig.json")), true);
        $appKey = $testConfig["AppKey"];
        $appSid = $testConfig["AppSid"];
        $baseUrl = $testConfig["BaseUrl"];
        $debug = $testConfig["Debug"];
        $this->config->setAppKey($appKey);
        $this->config->setAppSid($appSid);
        $this->config->setHost($baseUrl);
        $this->config->setDebug($debug);

        $rules = \GuzzleHttp\json_decode(file_get_contents(realpath(__DIR__."/../../testRules.json")), true);
        $this->fileRules = $rules["Files"];
        $this->rules = $rules["Messages"];
        $this->values = $rules["Values"];
        $this->okToFailValues = $rules["OKToNotFail"];

        $this->storage = new StorageApi();
        $this->storage->getConfig()->setAppKey($appKey);
        $this->storage->getConfig()->setAppSid($appSid);
        $this->storage->getConfig()->setHost($baseUrl);
    }
    
    protected function initialize($functionName, $invalidFieldName, $invalidFieldValue)
    {
        $expectedValues = $this->applyRules($functionName, $invalidFieldName, $invalidFieldValue);
        $fileRulesToApply = $this->applyFileRules($functionName, $invalidFieldName, $invalidFieldValue);
        foreach ($fileRulesToApply as $path => $rule)
        {
            if ($rule["Action"] == "Put")
            {
                $putRequest = new PutCreateRequest($path, realpath(__DIR__.'/../..').'/TestData/'.$rule["ActualName"]);
                $this->storage->PutCreate($putRequest);
            }
            else if ($rule["Action"] == "Delete")
            {
                $this->storage->DeleteFile(new DeleteFileRequest($path));
            }
        }
        return $expectedValues;
    }

    private function applyRules($functionName, $invalidFieldName, $invalidFieldValue)
    {
        $expectedCode = 0;
        $expectedMessage = "An error occured.";
        foreach ($this->rules as $rule)
        {
            $this->applyRule($rule, $expectedCode, $expectedMessage, $functionName, $invalidFieldName, $invalidFieldValue);
        }
        return [ $expectedCode, $expectedMessage ];
    }

    private function applyFileRules($functionName, $invalidFieldName, $invalidFieldValue)
    {
        $rulesToApply = [];
        foreach ($this->fileRules as $rule)
        {
            $this->applyFileRule($rule, $rulesToApply, $functionName, $invalidFieldName, $invalidFieldValue);
        }
        return $rulesToApply;
    }

    private function applyRule($rule, &$expectedCode, &$expectedMessage, $functionName, $invalidFieldName, $invalidFieldValue)
    {
        if ($this->checkMethod($rule, $functionName, $invalidFieldName)
            && $this->checkInvalid($rule, $invalidFieldName)
            && $this->checkParameter($rule, $invalidFieldName))
        {
            if (array_key_exists("Code", $rule))
            {
                $expectedCode = $rule["Code"];
            }
            if (array_key_exists("Message", $rule))
            {
                $expectedMessage = str_replace("%v", is_array($invalidFieldValue) ? implode(",", $invalidFieldValue) : $invalidFieldValue, $rule["Message"]);
            }
        }
    }

    private function applyFileRule($rule, &$files, $functionName, $invalidFieldName, $invalidFieldValue)
    {
        if ($this->checkMethod($rule, $functionName, $invalidFieldName) && $this->checkParameter($rule, $invalidFieldName))
        {
            if (array_key_exists("File", $rule))
            {
                $fileFolder = "TempSlidesSDK";
                if (array_key_exists("Folder", $rule))
                {
                    $fileFolder = str_replace("%v", is_array($invalidFieldValue) ? implode(",", $invalidFieldValue) : $invalidFieldValue, $rule["Folder"]);
                }
                $fileName = str_replace("%v", is_array($invalidFieldValue) ? implode(",", $invalidFieldValue) : $invalidFieldValue, $rule["File"]);
                $filePath = $fileFolder."/".$fileName;
                $files[$fileFolder."/".$fileName] = $rule;
                $files[$fileFolder."/".$fileName]["ActualName"] = $fileName;
            }
        }
    }

    private function checkMethod($rule, $functionName, $invalidFieldName)
    {
        return !array_key_exists("Method", $rule) || strcasecmp($functionName, $rule["Method"]) == 0;
    }

    private function checkInvalid($rule, $invalidFieldName)
    {
        return !array_key_exists("Invalid", $rule) || $rule["Invalid"] != is_null($invalidFieldName);
    }

    private function checkParameter($rule, $invalidFieldName)
    {
        return !array_key_exists("Parameter", $rule) || strcasecmp($invalidFieldName, $rule["Parameter"]) == 0;
    }

    private $rules;
    private $fileRules;
}
