<?php

namespace App\Entity;

use App\Repository\HistorialViaxesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormTypeInterface;

#[ORM\Entity(repositoryClass: HistorialViaxesRepository::class)]
class HistorialViaxes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $destino = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    #[ORM\Column]
    private ?int $duracion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motivo = null;

    #[ORM\Column(length: 55)]
    private ?string $transporte = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $aloxamento = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDestino(): ?string
    {
        return $this->destino;
    }

    public function setDestino(string $destino): static
    {
        $this->destino = $destino;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion): static
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getMotivo(): ?string
    {
        return $this->motivo;
    }

    public function setMotivo(?string $motivo): static
    {
        $this->motivo = $motivo;

        return $this;
    }

    public function getTransporte(): ?string
    {
        return $this->transporte;
    }

    public function setTransporte(string $transporte): static
    {
        $this->transporte = $transporte;

        return $this;
    }

    public function getAloxamento(): ?string
    {
        return $this->aloxamento;
    }

    public function setAloxamento(?string $aloxamento): static
    {
        $this->aloxamento = $aloxamento;

        return $this;
    }
}
