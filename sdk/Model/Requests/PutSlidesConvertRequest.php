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


namespace Aspose\Slides\Cloud\Sdk\Model\Requests;
/*
 * Request model for putSlidesConvert operation.
 */
class PutSlidesConvertRequest
{
    /*
     * Export format.
     */
    public $format;

    /*
     * Path to save result.
     */
    public $outPath;

    /*
     * Document data.
     */
    public $document;

    /*
     * Document password.
     */
    public $password;

    /*
     * Custom fonts folder.
     */
    public $fontsFolder;

    /*
     * Initializes a new instance of the PutSlidesConvertRequest class.
     *  
     * @param int $format Export format.
     * @param string $outPath Path to save result.
     * @param \SplFileObject $document Document data.
     * @param string $password Document password.
     * @param string $fontsFolder Custom fonts folder.
     */
    public function __construct($format, $outPath, $document = null, $password = null, $fontsFolder = null)
    {
        $this->format = $format;
        $this->outPath = $outPath;
        $this->document = $document;
        $this->password = $password;
        $this->fontsFolder = $fontsFolder;
    }

    /*
     * Export format.
     */
    public function get_format()
    {
        return $this->format;
    }

    /*
     * Export format.
     */
    public function set_format($value)
    {
        $this->format = $value;
        return $this;
    }
    /*
     * Path to save result.
     */
    public function get_outPath()
    {
        return $this->outPath;
    }

    /*
     * Path to save result.
     */
    public function set_outPath($value)
    {
        $this->outPath = $value;
        return $this;
    }
    /*
     * Document data.
     */
    public function get_document()
    {
        return $this->document;
    }

    /*
     * Document data.
     */
    public function set_document($value)
    {
        $this->document = $value;
        return $this;
    }
    /*
     * Document password.
     */
    public function get_password()
    {
        return $this->password;
    }

    /*
     * Document password.
     */
    public function set_password($value)
    {
        $this->password = $value;
        return $this;
    }
    /*
     * Custom fonts folder.
     */
    public function get_fontsFolder()
    {
        return $this->fontsFolder;
    }

    /*
     * Custom fonts folder.
     */
    public function set_fontsFolder($value)
    {
        $this->fontsFolder = $value;
        return $this;
    }
}
