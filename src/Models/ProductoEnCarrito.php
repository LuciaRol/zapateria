<?php

namespace Models;

class ProductoEnCarrito
{
    private int $id;
    private int $categoria_id;
    private string $nombre;
    private ?string $descripcion;
    private float $precio;
    private int $stock;
    private ?string $oferta;
    private string $fecha;
    private ?string $imagen;

    private array $productos;

    public function __construct(
        int $id,
        int $categoria_id,
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
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->oferta = $oferta;
        $this->fecha = $fecha;
        $this->imagen = $imagen;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoriaId(): int
    {
        return $this->categoria_id;
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

    // Setters
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function setOferta(?string $oferta): void
    {
        $this->oferta = $oferta;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function setImagen(?string $imagen): void
    {
        $this->imagen = $imagen;
    }

    public function agregarProducto(ProductoEnCarrito $producto)
    {
        $this->productos[] = $producto;
    }

}

