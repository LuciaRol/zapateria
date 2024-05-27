<?php

namespace Models;

class Producto
{
    private int $id;
    private int $categoria_id;
    private string $nombre_categoria;

    private string $nombre;
    private ?string $descripcion;
    private float $precio;
    private int $stock;
    private ?string $oferta;
    private string $fecha;
    private ?string $imagen;

    public function __construct(
        int $id,
        int $categoria_id,
        string $nombre_categoria,
        string $nombre,
        ?string $descripcion,
        float $precio,
        int $stock,
        ?string $oferta,
        string $fecha,
        ?string $imagen
    ) {
        $this->id = $id;
        $this->categoria_id = $categoria_id;
        $this->nombre_categoria = $nombre_categoria;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->oferta = $oferta;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoriaId(): int
    {
        return $this->categoria_id;
    }

    public function getNombre_categoria(): string
    {
        return $this->nombre_categoria;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getOferta(): ?string
    {
        return $this->oferta;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }
}
