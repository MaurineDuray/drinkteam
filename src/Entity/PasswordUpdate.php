<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    #[Assert\NotBlank(message:'Vous devez renseigner votre ancien mot de passe')]
    private ?string $oldPassword = null;

    #[Assert\Length(min: 8, max: 255, minMessage: "Votre mot de passe doit faire plus de 8 caractères")]
    private ?string $newPassword = null;

    #[Assert\EqualTo(propertyPath:"newPassword", message:"Vous n'avez pas correctement confirmé votre mot de passe")]
    private ?string $confirmPassword = null;


    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
