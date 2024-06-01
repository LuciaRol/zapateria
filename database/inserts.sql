-- Crear la base de datos y usarla
USE tienda;

-- Insertar datos en la tabla usuarios
/*INSERT INTO usuarios (nombre, apellidos, email, contrasena, rol) VALUES
('admin', 'admin', 'admin@admin.com', 'admin', 'admin'),
('usur1', 'usur1', 'usur1@usur1.com', 'usur1', 'usur'),
('usur2', 'usur2', 'usur2@usur2.com', 'usur2', 'usur');
*/ -- No se pueden crear los datos con simples inserts dado que PhP encripta la contraseña. Hay que crear los usuarios primero en la aplicación y luego hacer los inserts
-- Insertar datos en la tabla categorias
INSERT INTO categorias (nombre) VALUES
('Zapatos de Vestir'),
('Zapatillas Deportivas'),
('Botas'),
('Sandalias'),
('Zapatos Casuales');

-- Insertar datos en la tabla productos
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(1, 'Zapatos de vestir', 'Zapatos de cuero negro, ideales para ocasiones formales.', 99.99, 50, 0, '2024-05-01', 'zapato1.jpg'),
(2, 'Zapatillas deportivas', 'Zapatillas deportivas para correr o entrenar.', 79.99, 30, 1, '2024-04-15', 'zapato2.jpg'),
(3, 'Botas de invierno', 'Botas resistentes al agua, perfectas para el invierno.', 129.99, 100, 0, '2024-03-10', 'zapato3.jpg'),
(4, 'Sandalias de verano', 'Sandalias cómodas y elegantes para el verano.', 49.99, 80, 1, '2024-02-25', 'zapato4.jpg'),
(5, 'Zapatos casuales', 'Zapatos informales para uso diario.', 59.99, 200, 0, '2024-01-20', 'zapato5.jpg');
-- Insertar datos en la tabla pedidos
INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES
(1, 'Madrid', 'Madrid', 'Calle Mayor, 1', 719.98, 'no enviado', '2024-05-05', '10:30:00'),
(2, 'Barcelona', 'Barcelona', 'Calle Gran Vía, 50', 69.98, 'no enviado', '2024-05-10', '14:45:00');

-- Insertar datos en la tabla lineas_pedidos
INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES
(1, 1, 1),  
(1, 3, 1),  
(2, 5, 2);  
