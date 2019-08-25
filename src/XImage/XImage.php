<?php

namespace XWX\Common\XImage;


use XWX\Common\H;

class XImage
{
    protected $pub_image;
    protected $pub_fonts;

    const image_png = 'png';
    const image_jpeg = 'jpeg';
    const image_git = 'gif';


    public function __construct($width, $height, $bg_red = 204, $bg_green = 204, $bg_blue = 204)
    {
        $assetsPath = __DIR__ . '/assets/ttf/';
        if (!H::funcIsWin())
        {
            $assetsPath = __DIR__ . '\\assets\\ttf\\';
        }

        // 合并字体库
        $this->pub_fonts = $this->funcLoadFonts($assetsPath);
//        var_dump($this->pub_fonts);


        //创建
        $this->pub_image = imagecreate($width, $height);

        //默认：设置背景颜色
        imagecolorallocate($this->pub_image, $bg_red, $bg_green, $bg_blue);
    }


    /**
     * 获取画图对象
     *
     * @return resource
     */
    function getImage()
    {
        return $this->pub_image;
    }

    /**
     * 获取字体
     *
     * @param null $key
     * @return array|string|null
     */
    function getFonts($key = null)
    {
        if (H::funcStrHasAnyText($key))
        {
            return H::funcArrayGet($this->pub_fonts, $key);
        }

        return $this->pub_fonts;
    }


    /**
     * 添加文本
     *
     * @param $text
     * @param $size 大小
     * @param $angle 角度
     * @param $x
     * @param $y
     * @param $color
     * @param null $font
     * @return $this
     */
    public function addText($text, $size, $angle, $x, $y, $color, $font = null)
    {
        $text = strval($text);

        //没有指定字体，会随机出一个
        if ($font == null)
        {
            $font = $this->pub_fonts[array_rand($this->pub_fonts)];
        }

        imagettftext($this->pub_image, $size, $angle, $x, $y, $color, $font, $text);


        return $this;
    }

    /**
     * @param $text
     * @param $x
     * @param $y
     * @param $color
     * @param int $font 1-5
     * @return $this
     */
    public function addString($text, $x, $y, $color, $font = 5)
    {
        imagestring($this->pub_image, $font, $x, $y, $text, $color);

        return $this;
    }

    /**
     * 添加像素点
     *
     * @param $x
     * @param $y
     * @param $color
     * @return $this
     */
    public function addPixel($x, $y, $color)
    {
        imagesetpixel($this->pub_image, $x, $y, $color);

        return $this;
    }

    /**
     * 获取颜色
     *
     * @param $red
     * @param $green
     * @param $blue
     * @param int $alpha 透明度:1-127
     *
     * @return int
     */
    public function setColor($red, $green, $blue, $alpha = 0)
    {
        if ($alpha > 127)
        {
            //127：完全透明
            $alpha = 127;
        }

        return imagecolorallocatealpha($this->pub_image, $red, $green, $blue, $alpha);
    }


    /**
     * 以PNG格式输出图像
     */
    public function toPng()
    {
        header("content-type:image/png");
        $this->save(null, XImage::image_png);
    }

    /**
     * 保存图片
     *
     * @param $file_path 图片路径
     * @param string $file_type 文件格式
     * jpeg
     * imagejpeg()
     * png
     * imagepng()
     * gif
     * imagegif()
     *
     * @return bool
     */
    public function save($file_path, $file_type = XImage::image_jpeg)
    {
        $func = 'image' . $file_type;

        $res = $func($this->pub_image, $file_path);

        $this->destroy();

        return $res;
    }

    /**
     * 销毁图像资源
     */
    public function destroy()
    {
        imagedestroy($this->pub_image);
    }


    /**
     * 加载字体资源文件
     *
     * @param $fonts_path
     * @return array
     * @throws \Exception
     */
    private function funcLoadFonts($fonts_path)
    {
        if (!is_dir($fonts_path))
        {
            throw new \Exception('dir is not find:' . $fonts_path);
        }

        $dir = dir($fonts_path);

        $fonts = [];
        while (false !== ($file = $dir->read()))
        {
            if (' . ' != $file[0] && substr($file, -4) == '.ttf')
            {
                $fonts[] = $fonts_path . $file;
            }
        }
        $dir->close();

        return $fonts;
    }
}