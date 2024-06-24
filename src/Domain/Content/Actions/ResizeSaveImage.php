<?php

namespace Domain\Content\Actions;

use Intervention\Image\Facades\Image;
use Support\Services\DigitalOcean\Spaces;

class ResizeSaveImage
{
//    public $imageQuality = 80;

    public array $thumbs = [];

    public array $saved;

    public function __construct($fileStream, $setWidth, $setHeight = 0, $crop = false, $exact = false, $setImage = true)
    {
        $this->fileStream = $fileStream;

        $this->width($setWidth);
        $this->height($setHeight);

        $this->crop($crop);

        $this->bgcolor = '#fff';
        $this->exact = $exact;

        if ($setImage) {
            $this->setImageFromFileStream();
        }
    }

    public function setImageFromFileStream()
    {
        $this->setImage(Image::make($this->fileStream));

        return $this;
    }

    public function thumb($width, $height, $crop = false)
    {
        $this->thumbs[] = (new static($this->fileStream, $width, $height, $crop)); //, false, false))
//            ->setImage(clone($this->image));

        return $this;
    }

    public function thumbs(array $thumbs)
    {
        foreach ($thumbs as $thumb) {
            $this->thumb($thumb['width'], $thumb['height'], $thumb['crop']);
        }

        return $this;
    }

    public function setImage(\Intervention\Image\Image $image): ResizeSaveImage
    {
        $this->image = $image;

        $this->currentWidth = $this->image->width();
        $this->currentHeight = $this->image->height();
        $this->fileType = $this->image->mime();

        return $this;
    }

    public function save($prename = '', $path = 'test/')
    {
        $this->saveThumbs($prename, $path);

        $fileName = $this->filename($prename.$this->fileStream->hashName());

        if (Spaces::resolve()->push($path.$fileName, $this->image->stream())) {
            $this->saved[] = $fileName;

            return $fileName;
        }

        return false;
    }

    public function resize()
    {
        $this->resizingWidth = $this->currentWidth;
        $this->resizingHeight = $this->currentHeight;

        if ($this->exact || ($this->setWidth > 0 && $this->currentWidth > $this->setWidth) || ($this->setHeight > 0 && $this->currentHeight > $this->setHeight)) {
            $this->resizeImage();

            if (($this->setWidth > 0 && $this->currentWidth > $this->setWidth) || ($this->setHeight > 0 && $this->currentHeight > $this->setHeight)) {
                $this->image->sharpen(5);
            }

//            $this->resize->save($set_path . $set_img, $this->imageQuality);
        } else {
            $this->image->sharpen(0);
//            $this->resize->save($set_path . $set_img, $this->imageQuality);
        }

        $this->resizeThumbs();

        return $this;
    }

    public function _crop($crop = false)
    {
        if ($crop && ($crop === true || ! in_array($crop, ['top', 'bottom', 'left', 'right', 'top left', 'top right', 'bottom left', 'bottom right', 'center']))) {
            $crop = 'center';
        }

        return $crop;
    }

    public function resizeCanvas($setWidth, $setHeight, $crop)
    {
        $this->image->resizeCanvas(
            $setWidth,
            $setHeight,
            $this->_crop($crop),
            false,
            'rgba(255,255,255,0)'
        );

        return $this;
    }

    public function filename($filename)
    {
        $prename = '';
        if ($this->setWidthOriginal > 0) {
            $prename .= 'W'.$this->setWidthOriginal.'-';
        }
        if ($this->setHeightOriginal > 0) {
            $prename .= 'H'.$this->setHeightOriginal.'-';
        }

        return $prename.$filename;
    }

    /**
     * @param $setWidth
     */
    protected function width($setWidth)
    {
        $this->setWidth = $setWidth;
        $this->setWidthOriginal = $setWidth;

        return $this;
    }

    /**
     * @param $setHeight
     */
    protected function height($setHeight)
    {
        $this->setHeight = $setHeight;
        $this->setHeightOriginal = $setHeight;

        return $this;
    }

    protected function crop($crop)
    {
        $this->crop = $crop !== '' ? $crop : false;

        return $this;
    }

    protected function resizeThumbs()
    {
        if (count($this->thumbs)) {
            foreach ($this->thumbs as $thumb) {
                $thumb->resize();
            }
        }

        return $this;
    }

    protected function saveThumbs($prename, $path)
    {
        if (count($this->thumbs)) {
            foreach ($this->thumbs as $thumb) {
                $this->saved[] = $thumb->save($prename, $path);
            }
        }

        return $this;
    }

    private function resizeImage()
    {
        if (! $this->setHeight || ! $this->setWidth) {
            if ($this->setWidth && ! $this->setHeight) {
                if ($this->setWidth > $this->currentWidth) {
                    $this->setHeight = $this->currentHeight;
                } else {
                    $ratio = $this->setWidth / $this->currentWidth;
                    $this->setHeight = round($this->currentHeight * $ratio);
                }
            } elseif ($this->setHeight && ! $this->setWidth) {
                if ($this->setHeight > $this->currentHeight) {
                    $this->setWidth = $this->currentWidth;
                } else {
                    $ratio = $this->setHeight / $this->currentHeight;
                    $this->setWidth = round($this->currentWidth * $ratio);
                }
            }
        }

        if ($this->currentWidth > $this->setWidth && $this->currentHeight > $this->setHeight && $this->crop) {
            $this->image->fit(
                $this->setWidth,
                $this->setHeight,
                function ($constraint) {
                    $constraint->upsize();
                },
                $this->_crop($this->crop)
            );
        } elseif ($this->currentWidth > $this->setWidth) {//shrink image width, resize canvas for height
            $this->image->resize(
                $this->setWidth,
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            );

            $this->resizeCanvas(null, $this->setHeight, $this->crop);
        } elseif ($this->currentHeight > $this->setHeight) {//shrnk image height, resize canvas for width
            $this->image->resize(
                null,
                $this->setHeight,
                function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                }
            );

            $this->resizeCanvas($this->setWidth, null, $this->crop);
        } else {
            $this->resizeCanvas($this->setWidth, $this->setHeight, $this->crop);
        }

        $this->resizingWidth = $this->setWidth;
        $this->resizingHeight = $this->setHeight;

        return $this;
    }
}
