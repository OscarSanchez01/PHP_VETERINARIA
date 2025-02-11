-- Eliminar tablas si existen
DROP TABLE IF EXISTS PERRO_RECIBE_SER;
DROP TABLE IF EXISTS EMPLEADOS;
DROP TABLE IF EXISTS PERROS;
DROP TABLE IF EXISTS SERVICIOS;
DROP TABLE IF EXISTS CLIENTES;

-- Crear tabla de CLIENTES
CREATE TABLE CLIENTES (
    Dni VARCHAR(9) PRIMARY KEY,
    Nombre VARCHAR(15) NOT NULL,
    Apellido1 VARCHAR(15) NOT NULL,
    Apellido2 VARCHAR(15) NOT NULL, 
    Direccion VARCHAR(200),
    Tlfno VARCHAR(9)
);

-- Insertar registros en la tabla CLIENTES
INSERT INTO CLIENTES (Dni, Nombre, Apellido1, Apellido2, Direccion, Tlfno) VALUES 
('12345678A', 'Carlos', 'García', 'López', 'Calle Mayor$10$45600$Talavera de la Reina$Toledo', '600000001'),
('12345678B', 'María', 'Martínez', 'Fernández', 'Avenida de la Constitución$20$45600$Talavera de la Reina$Toledo', '600000002'),
('12345678C', 'Juan', 'Rodríguez', 'Gómez', 'Calle San Juan$15$45600$Talavera de la Reina$Toledo', '600000003'),
('12345678D', 'Ana', 'González', 'Ruiz', 'Plaza del Reloj$5$45600$Talavera de la Reina$Toledo', '600000004'),
('12345678E', 'Pedro', 'Hernández', 'Díaz', 'Calle del Sol$25$45600$Talavera de la Reina$Toledo', '600000005'),
('12345678F', 'Laura', 'Jiménez', 'Moreno', 'Avenida de los Reyes Católicos$12$45600$Talavera de la Reina$Toledo', '600000006'),
('32345678A', 'Raúl', 'Fernández', 'Pérez', 'Calle del Castillo$1$45560$Oropesa$Toledo', '600000026'),
('32345678B', 'Sofía', 'Moreno', 'García', 'Calle Mayor$5$45560$Oropesa$Toledo', '600000027'),
('32345678C', 'Ignacio', 'Serrano', 'Hernández', 'Plaza de la Villa$3$45560$Oropesa$Toledo', '600000028'),
('32345678D', 'Julia', 'Blanco', 'López', 'Calle Real$10$45560$Oropesa$Toledo', '600000029'),
('32345678E', 'Miguel', 'Núñez', 'Martín', 'Calle Iglesia$7$45560$Oropesa$Toledo', '600000030'),
('32345678F', 'César', 'Rojas', 'Mendoza', 'Calle San Miguel$2$45567$Lagartera$Toledo', '600000031'),
('32345678G', 'Paula', 'Cruz', 'Torres', 'Calle del Sol$6$45567$Lagartera$Toledo', '600000032'),
('32345678H', 'Héctor', 'Medina', 'Ruiz', 'Avenida de la Constitución$4$45672$Ventas de San Julián$Toledo', '600000033'),
('32345678I', 'Aitana', 'Vega', 'Romero', 'Calle Nueva$11$45672$Ventas de San Julián$Toledo', '600000034'),
('32345678J', 'Rubén', 'González', 'Díaz', 'Calle Ancha$9$45634$Calzada de Oropesa$Toledo', '600000035'),
('12345678G', 'Luis', 'Sánchez', 'Pérez', 'Calle Nueva$30$45600$Talavera de la Reina$Toledo', '600000007'),
('12345678H', 'Carmen', 'Torres', 'Ramírez', 'Calle Real$8$45600$Talavera de la Reina$Toledo', '600000008'),
('12345678I', 'Miguel', 'Vázquez', 'Álvarez', 'Avenida de la Libertad$35$45600$Talavera de la Reina$Toledo', '600000009'),
('12345678J', 'Sara', 'Romero', 'García', 'Calle Jardines$17$45600$Talavera de la Reina$Toledo', '600000010'),
('12345678K', 'David', 'Molina', 'Ortiz', 'Calle Olmo$2$45600$Talavera de la Reina$Toledo', '600000011'),
('12345678L', 'Elena', 'Domínguez', 'Núñez', 'Plaza Mayor$1$45600$Talavera de la Reina$Toledo', '600000012'),
('12345678M', 'Fernando', 'Santos', 'Gutiérrez', 'Avenida de la Paz$40$45600$Talavera de la Reina$Toledo', '600000013'),
('12345678N', 'Isabel', 'Ramos', 'Méndez', 'Calle Gran Vía$22$45600$Talavera de la Reina$Toledo', '600000014'),
('12345678O', 'Javier', 'Navarro', 'Cano', 'Calle del Río$14$45600$Talavera de la Reina$Toledo', '600000015'),
('12345678P', 'Patricia', 'Ortega', 'Serrano', 'Calle Luna$27$45600$Talavera de la Reina$Toledo', '600000016'),
('12345678Q', 'Alberto', 'Rubio', 'Blanco', 'Avenida del Prado$19$45600$Talavera de la Reina$Toledo', '600000017'),
('12345678R', 'Raquel', 'Gil', 'Martín', 'Calle Verde$13$45600$Talavera de la Reina$Toledo', '600000018'),
('12345678S', 'Andrés', 'Castro', 'Ruiz', 'Plaza Nueva$7$45600$Talavera de la Reina$Toledo', '600000019'),
('12345678T', 'Marta', 'Vega', 'Cabrera', 'Calle Azul$9$45600$Talavera de la Reina$Toledo', '600000020'),
('22345678A', 'Roberto', 'Martínez', 'Alonso', 'Calle de la Constitución$12$45510$Fuensalida$Toledo', '600000021'),
('22345678B', 'Alicia', 'Gómez', 'Fernández', 'Calle de la Iglesia$5$45510$Fuensalida$Toledo', '600000022'),
('22345678C', 'Manuel', 'López', 'García', 'Calle Real$8$45510$Fuensalida$Toledo', '600000023'),
('22345678D', 'Laura', 'Pérez', 'Sánchez', 'Calle San Juan$3$45510$Fuensalida$Toledo', '600000024'),
('22345678E', 'José', 'Rodríguez', 'Hernández', 'Avenida de la Paz$10$45510$Fuensalida$Toledo', '600000025');

