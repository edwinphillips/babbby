<?php

class ID3TagsReader {

    // array of possible sys tags (for old version of ID3)
    var $aTV22 = array(
        'TT2',
        'TAL',
        'TP1',
        'TRK',
        'TYE',
        'TLE',
        'ULT'
    );

    // array of titles for sys tags (for old version of ID3)
    var $aTV22t = array(
        'Title',
        'Album',
        'Author',
        'Track',
        'Year',
        'Lenght',
        'Lyric'
    );

    // array of possible sys tags (for last version of ID3)
    var $aTV23 = array(
        'TIT2',
        'TALB',
        'TPE1',
        'TPE2',
        'TRCK',
        'TYER',
        'TLEN',
        'USLT',
        'TPOS',
        'TCON',
        'TENC',
        'TCOP',
        'TPUB',
        'TOPE',
        'WXXX',
        'COMM',
        'TCOM'
    );

    // array of titles for sys tags (for last version of ID3)
    var $aTV23t = array(
        'Title',
        'Album',
        'Author',
        'AlbumAuthor',
        'Track',
        'Year',
        'Lenght',
        'Lyric',
        'Desc',
        'Genre',
        'Encoded',
        'Copyright',
        'Publisher',
        'OriginalArtist',
        'URL',
        'Comments',
        'Composer'
    );

    function __construct() {
    }

    /**
     * Return array of tags from passed MP3 path
     *
     * @param string $filepath
     * @return array
     */
    function get_tag_info($filepath) {

        // Read source file
        $filesize = filesize($filepath);
        $handle = fopen($filepath, 'r');
        $mp3data = fread($handle, $filesize);
        fclose($handle);

        // Obtain base info
        if (substr($mp3data, 0, 3) == 'ID3') {
            $taginfo['FileName'] = $filepath;
            $taginfo['Version'] = hexdec(bin2hex(substr($mp3data, 3, 1))) . '.' . hexdec(bin2hex(substr($mp3data, 4, 1)));
        }

        // Iterate through possible tags of idv2 (v2)
        if($taginfo['Version'] == '2.0') {
            for ($i = 0; $i < count($this->aTV22); $i++) {
                if (strpos($mp3data, $this->aTV22[$i] . chr(0)) != false) {

                    $string = '';
                    $position = strpos($mp3data, $this->aTV22[$i] . chr(0));
                    $length = hexdec(bin2hex(substr($mp3data, ($position + 3), 3)));

                    $data = substr($mp3data, $position, 6 + $length);
                    for ($a = 0; $a < strlen($data); $a++) {
                        $char = substr($data, $a, 1);
                        if ($char >= ' ' && $char <= '~')
                            $string .= $char;
                    }

                    if (substr($string, 0, 3) == $this->aTV22[$i]) {
                        $iSL = 3;
                        if ($this->aTV22[$i] == 'ULT') {
                            $iSL = 6;
                        }
                        $taginfo[$this->aTV22t[$i]] = substr($string, $iSL);
                    }
                }
            }
        }

        // Iterate through possible tags of idv2 (v3 and v4)
        if ($taginfo['Version'] == '3.0' || $taginfo['Version'] == '4.0') {
            for ($i = 0; $i < count($this->aTV23); $i++) {
                if (strpos($mp3data, $this->aTV23[$i] . chr(0)) != false) {

                    $string = '';
                    $position = strpos($mp3data, $this->aTV23[$i] . chr(0));
                    $length = hexdec(bin2hex(substr($mp3data, ($position + 5), 3)));

                    $data = substr($mp3data, $position, 9 + $length);
                    for ($a = 0; $a < strlen($data); $a++) {
                        $char = substr($data, $a, 1);
                        if ($char >= ' ' && $char <= '~') {
                            $string .= $char;
                        }
                    }

                    if (substr($string, 0, 4) == $this->aTV23[$i]) {
                        $iSL = 4;
                        if ($this->aTV23[$i] == 'USLT') {
                            $iSL = 7;
                        } elseif ($this->aTV23[$i] == 'TALB') {
                            $iSL = 5;
                        } elseif ($this->aTV23[$i] == 'TENC') {
                            $iSL = 6;
                        }
                        $taginfo[$this->aTV23t[$i]] = substr($string, $iSL);
                    }
                }
            }
        }

        return $taginfo;
    }
}