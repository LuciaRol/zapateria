-- Crear la base de datos y usarla
USE tienda;

-- Insertar datos en la tabla usuarios
INSERT INTO usuarios (nombre, apellidos, email, password, rol) VALUES
('Juan', 'Pérez López', 'juan.perez@example.com', 'password123', 'cliente'),
('Ana', 'García Sánchez', 'ana.garcia@example.com', 'password456', 'admin'),
('Luis', 'Rodríguez Fernández', 'luis.rodriguez@example.com', 'password789', 'cliente');

-- Insertar datos en la tabla categorias
INSERT INTO categorias (nombre) VALUES
('Electrónica'),
('Ropa'),
('Libros');

-- Insertar datos en la tabla productos
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(1, 'Teléfono Móvil', 'Un teléfono móvil de última generación', 699.99, 50, 0, '2024-05-01', 'telefono.jpg'),
(1, 'Televisor', 'Un televisor de alta definición', 899.99, 30, 1, '2024-04-15', 'televisor.jpg'),
(2, 'Camiseta', 'Camiseta 100% algodón', 19.99, 100, 0, '2024-03-10', 'camiseta.jpg'),
(2, 'Jeans', 'Jeans de denim azul', 49.99, 80, 1, '2024-02-25', 'jeans.jpg'),
(3, 'Libro de programación', 'Un libro sobre programación en Python', 29.99, 200, 0, '2024-01-20', 'libro_programacion.jpg');

-- Insertar datos en la tabla pedidos
INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES
(1, 'Madrid', 'Madrid', 'Calle Mayor, 1', 719.98, 'no enviado', '2024-05-05', '10:30:00'),
(2, 'Barcelona', 'Barcelona', 'Calle Gran Vía, 50', 69.98, 'no enviado', '2024-05-10', '14:45:00');

-- Insertar datos en la tabla lineas_pedidos
INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES
(1, 1, 1),  -- Pedido 1: 1 Teléfono Móvil
(1, 3, 1),  -- Pedido 1: 1 Camiseta
(2, 5, 2);  -- Pedido 2: 2 Libros de programación
