<?php

namespace venomousboy\yii2-rest-api-captcha;

use yii\captcha\CaptchaAction;
use yii\base\Exception;
use Yii;

class CaptchaHelper extends CaptchaAction
{
    private $code;

    /**
     * CaptchaHelper constructor.
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function generateImage(): string
    {
        $base64 = "data:image/png;base64," . base64_encode($this->renderImage($this->generateCode()));
        Yii::$app->cache->set($this->generateSessionKey($this->generateCode()), $this->generateCode());
        return $base64;
    }

    /**
     * @return string
     */
    public function generateCode(): string
    {
        if ($this->code) {
            return $this->code;
        }

        return $this->code = $this->generateVerifyCode();
    }

    /**
     * @param string $code
     * @return bool
     * @throws Exception
     */
    public function verify(string $code): bool
    {
        if (Yii::$app->cache->get($this->generateSessionKey($code)) === $code) {
            return true;
        }

        throw new Exception("Code is not valid \"{$code}\"");
    }

    /**
     * @return string
     */
    private function generateSessionKey(string $code): string
    {
        return base64_encode(Yii::$app->request->getRemoteIP() . Yii::$app->request->getUserAgent() . $code);
    }
}
