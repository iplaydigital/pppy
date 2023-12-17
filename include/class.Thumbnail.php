<?php
/*
 * class.Thumbnail.php
 *
 * Copyright (C) 2001 - 2008 Hidayet Dogan
 *
 * http://www.hido.net/projects/phpThumbnailer
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2, or (at your option)
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 */

class Thumbnail {
    var $errmsg	      = "";
    var $error	      = false;
    var $format	      = "";
    var $file	      = "";
    var $max_width    = 0;
    var $max_height   = 0;
    var $percent      = 0;
    var $jpeg_quality = 100;
    var $size         = array();

    function Thumbnail($file, $max_width = 0, $max_height = 0, $percent = 0, $jpeg_quality = 75) {
	if (!file_exists($file)) {
	    $this->errmsg = "File doesn't exists";
	    $this->error  = true;
	}
	else if (!is_readable($file)) {
	    $this->errmsg = "File is not readable";
	    $this->error  = true;
	}

        $this->size = getimagesize($file);

        switch ($this->size[2]) {
            case IMAGETYPE_GIF:
                $this->format = "GIF";
                break;
            case IMAGETYPE_JPEG:
                $this->format = "JPEG";
                break;
            case IMAGETYPE_PNG:
                $this->format = "PNG";
                break;
            default:
                $this->errmsg = "Unknown file format";
                $this->error  = true;
                break;
        }

	if ($max_width == 0 && $max_height == 0 && $percent == 0) {
	    $percent = 100;
	}

	$this->max_width    = $max_width;
	$this->max_height   = $max_height;
	$this->percent	    = $percent;
	$this->file	    = $file;
	$this->jpeg_quality = $jpeg_quality;
    }

    function calc_width($width, $height) {
	$new_width  = $this->max_width;
	$new_wp     = (100 * $new_width) / $width;
	$new_height = ($height * $new_wp) / 100;
	return array($new_width, $new_height);
    }

    function calc_height($width, $height) {
	$new_height = $this->max_height;
	$new_hp     = (100 * $new_height) / $height;
	$new_width  = ($width * $new_hp) / 100;
	return array($new_width, $new_height);
    }

    function calc_percent($width, $height) {
	$new_width  = ($width * $this->percent) / 100;
	$new_height = ($height * $this->percent) / 100;
	return array($new_width, $new_height);
    }

    function return_value($array) {
	$array[0] = intval($array[0]);
	$array[1] = intval($array[1]);
	return $array;
    }

    function calc_image_size($width, $height) {
	$new_size = array($width, $height);

	if ($this->max_width > 0 && $width > $this->max_width) {
	    $new_size = $this->calc_width($width, $height);

	    if ($this->max_height > 0 && $new_size[1] > $this->max_height) {
		$new_size = $this->calc_height($new_size[0], $new_size[1]);
	    }

	    return $this->return_value($new_size);
	}

	if ($this->max_height > 0 && $height > $this->max_height) {
	    $new_size = $this->calc_height($width, $height);
	    return $this->return_value($new_size);
	}

	if ($this->percent > 0) {
	    $new_size = $this->calc_percent($width, $height);
	    return $this->return_value($new_size);
	}

	return $this->return_value($new_size);
    }

    function show_error_image() {
	header("Content-type: image/png");
	$err_img   = imagecreate(220, 25);
	$bg_color  = imagecolorallocate($err_img, 0, 0, 0);
	$fg_color1 = imagecolorallocate($err_img, 255, 255, 255);
	$fg_color2 = imagecolorallocate($err_img, 255, 0, 0);
	imagestring($err_img, 3, 6, 6, "ERROR:", $fg_color2);
	imagestring($err_img, 3, 55, 6, $this->errmsg, $fg_color1);
	imagepng($err_img);
	imagedestroy($err_img);
    }

    function show($name = "") {
	if ($this->error) {
	    $this->show_error_image();
	    return;
	}

	$new_size  = $this->calc_image_size($this->size[0], $this->size[1]);
	#
	# Good idea from Mariano Cano P�rez
	# Requires GD 2.0.1 (PHP >= 4.0.6)
	#
	if (function_exists("imagecreatetruecolor")) {
	    $new_image = imagecreatetruecolor($new_size[0], $new_size[1]);
	}
	else {
	    $new_image = imagecreate($new_size[0], $new_size[1]);
	}

	switch ($this->format) {
	    case "GIF":
		$old_image = imagecreatefromgif($this->file);
		break;
	    case "JPEG":
		$old_image = imagecreatefromjpeg($this->file);
		break;
	    case "PNG":
		$old_image = imagecreatefrompng($this->file);
		break;
	}

	#
	# Good idea from Michael Wald
	# Requires GD 2.0.1 (PHP >= 4.0.6)
	#
	if (function_exists("imagecopyresampled")) {
	    imagecopyresampled($new_image, $old_image, 0, 0, 0, 0, $new_size[0], $new_size[1], $this->size[0], $this->size[1]);
	}
	else {
	    imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_size[0], $new_size[1], $this->size[0], $this->size[1]);
	}

	switch ($this->format) {
	    case "GIF":
		if (!empty($name)) {
		    imagegif($new_image, $name);
		}
		else {
		    header("Content-type: image/gif");
		    imagegif($new_image);
		}
		break;
	    case "JPEG":
		if (!empty($name)) {
		    imagejpeg($new_image, $name, $this->jpeg_quality);
		}
		else {
		    header("Content-type: image/jpeg");
		    imagejpeg($new_image, "", $this->jpeg_quality);
		}
		break;
	    case "PNG":
		if (!empty($name)) {
		    imagepng($new_image, $name);
		}
		else {
		    header("Content-type: image/png");
		    imagepng($new_image);
		}
		break;
	}

	imagedestroy($new_image);
	imagedestroy($old_image);
	return;
    }

    function save($name) {
	$this->show($name);
    }
}
?>
