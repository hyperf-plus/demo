<?php
declare(strict_types=1);


namespace App\Entity;

/**
 *
 * Class UserInfo
 * @package App\Model\Entity
 */
class WeUser extends EntityBean
{
    /**
     * @var string
     */
    protected $openid;
    /**
     * @var string
     */
    protected $nickname;
    /**
     * @var integer
     */
    protected $sex;
    /**
     * @var string
     */
    protected $language;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $province;
    /**
     * @var string
     */
    protected $country;
    /**
     * @var string
     */
    protected $avatarUrl;

    /**
     * @var string
     */
    protected $unionid;

    /**
     * @return string
     */
    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    /**
     * @param string $openid
     */
    public function setOpenid(?string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @return string
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return int
     */
    public function getSex()
    {
        return (int)$this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex($sex): void
    {
        $this->sex = (int)$sex;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language): void
    {
        $this->language = (string)$language;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province): void
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }


    /**
     * @return array
     */
    public function getGender()
    {
        return $this->sex;
    }

    /**
     * @param array $privilege
     */
    public function setGender($privilege): void
    {
        $this->sex = $privilege;
    }

    /**
     * @return string
     */
    public function getUnionid()
    {
        return $this->unionid ?? '';
    }

    /**
     * @param string $unionid
     */
    public function setUnionid($unionid): void
    {
        $this->unionid = $unionid;
    }

    /**
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * @param string $avatarUrl
     */
    public function setAvatarUrl($avatarUrl): void
    {
        $this->avatarUrl = $avatarUrl;
    }
}