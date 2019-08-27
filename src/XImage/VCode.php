<?php

namespace XWX\Common\XImage;


use XWX\Common\H;

class VCode
{
    /** @var XImage */
    protected $pub_app_images;

    protected $pub_width;
    protected $pub_height;

    protected $pub_set_noise; //是否设置画干扰杂字符
    protected $pub_set_font_size; //字体大小


    public function __construct($font_size = 30, $set_noise = true)
    {
        $this->pub_set_noise = $set_noise;
        $this->pub_set_font_size = $font_size;
    }

    /**
     * 输出png图片
     *
     * @param $code
     * @throws \Exception
     */
    function funcCodeToPng($code)
    {
        try
        {
            $this->funcDraw($code);

            $this->pub_app_images->toPng();
        }
        catch (\Exception $ex)
        {
            $this->pub_app_images->destroy();

            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * 保存图片
     *
     * @param $code
     * @param $save_path
     * @throws \Exception
     */
    function funcCodeSave($code, $save_path)
    {
        try
        {
            $this->funcDraw($code);

            $this->pub_app_images->save($save_path, XImage::image_jpeg);
        }
        catch (\Exception $ex)
        {
            $this->pub_app_images->destroy();

            throw new \Exception($ex->getMessage());
        }
    }


    private function funcDraw($code)
    {
        if (H::funcStrIsNullOrEmpty($code))
        {
            throw new \Exception('code is null');
        }


        $font_size = $this->pub_set_font_size;

        $code = strval($code);
        $code_len = strlen($code);

        $this->pub_width = $font_size * $code_len * 1.5 + $font_size / 2;
        $this->pub_height = $font_size * 2;
        $this->pub_app_images = new XImage($this->pub_width, $this->pub_height);

        $font_color = $this->pub_app_images->setColor(mt_rand(1, 150), mt_rand(1, 150), mt_rand(1, 150));


        if ($this->pub_set_noise)
        {
            //画干扰杂字符
            $this->funcSetNoise();
        }


        // 绘验证码
        $x = 0; // 验证码第N个字符的左边距
        for ($i = 0; $i < $code_len; $i++)
        {
            $x += mt_rand($font_size * 1.2, $font_size * 1.4);
            $y = $font_size * 1.5;

            // 写一个验证码字符
            $string1 = $code[$i];
            $this->pub_app_images->addText($string1, $font_size, mt_rand(-50, 50), $x, $y, $font_color);
        }
    }

    /**
     * 画干扰杂字符
     */
    private function funcSetNoise()
    {
        $noise_list = '2345678abcdefhijkmnpqrstuvwxyz';
        for ($i = 0; $i < 10; $i++)
        {
            $noise_color = $this->pub_app_images->setColor(mt_rand(150, 225), mt_rand(150, 225), mt_rand(150, 225));
            for ($j = 0; $j < 5; $j++)
            {
                $text = $noise_list[mt_rand(0, 29)];

                // 绘杂点
                $this->pub_app_images->addString($text, mt_rand(0, $this->pub_width), mt_rand(0, $this->pub_height), $noise_color);
            }
        }
    }
}