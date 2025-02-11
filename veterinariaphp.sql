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




-- Crear tabla de PERROS
CREATE TABLE PERROS (
    ID_Perro INT PRIMARY KEY AUTO_INCREMENT,
    Dni_duenio VARCHAR(9),
    Nombre VARCHAR(20) NOT NULL,
    Fecha_Nto DATE,
    Raza VARCHAR(40) NOT NULL,
    Peso DECIMAL(5,2),
    Altura INT,
    Observaciones VARCHAR(200),
    Numero_Chip VARCHAR(15) NOT NULL UNIQUE,
    Sexo ENUM('Macho', 'Hembra'),
    FOREIGN KEY (Dni_duenio) REFERENCES CLIENTES(Dni)
);

-- Insertar registros en la tabla PERROS
INSERT INTO PERROS (Dni_duenio, Nombre, Fecha_Nto, Raza, Peso, Altura, Observaciones, Numero_Chip, Sexo) VALUES 
('12345678A', 'Rex', '2022-08-15', 'Labrador Retriever', 30.5, 60, 'Activo y juguetón', '001-0001-00001', 'Macho'),
('12345678B', 'Bella', '2021-05-10', 'Bulldog Francés', 12.7, 30, 'Juguetona y cariñosa', '001-0001-00002', 'Hembra'),
('12345678C', 'Max', '2023-02-01', 'Pastor Alemán', 35.2, 65, 'Excelente guardián', '001-0001-00003', 'Macho'),
('12345678D', 'Luna', '2023-06-20', 'Golden Retriever', 31.8, 58, 'Es un perro muy aprensivo', '001-0001-00004', 'Hembra'),
('12345678E', 'Charlie', '2018-07-12', 'Beagle', 15.1, 40, 'Activo y curioso', '001-0001-00005', 'Macho'),
('12345678F', 'Daisy', '2023-01-20', 'Yorkshire Terrier', 3.4, 20, 'Valiente y enérgica', '001-0001-00006', 'Hembra'),
('12345678G', 'Rocky', '2021-09-30', 'Boxer', 29.0, 60, 'Fuerte y protector', '001-0001-00007', 'Macho'),
('12345678H', 'Sadie', '2010-04-18', 'Caniche', 4.6, 25, 'Juguetona y cariñosa', '001-0001-00008', 'Hembra'),
('12345678I', 'Buster', '2019-11-05', 'Dachshund', 9.3, 22, 'Leal y curioso', '001-0001-00009', 'Macho'),
('12345678J', 'Molly', '2007-03-25', 'Rottweiler', 44.5, 68, 'Excelente guardián', '001-0001-00010', 'Hembra'),
('12345678K', 'Toby', '2020-12-10', 'Chihuahua', 2.5, 18, 'Pequeño pero valiente', '001-0001-00011', 'Macho'),
('12345678L', 'Bailey', '2021-03-15', 'Schnauzer', 7.9, 35, 'Obediente y leal', '001-0001-00012', 'Macho'),
('12345678M', 'Coco', '2019-06-25', 'Cocker Spaniel', 13.2, 39, 'Amigable y activo', '001-0001-00013', 'Macho'),
('12345678N', 'Jake', '2018-09-30', 'Border Collie', 18.4, 53, 'Inteligente y trabajador', '001-0001-00014', 'Macho'),
('12345678O', 'Lucy', '2017-05-20', 'Shih Tzu', 6.2, 25, 'Dócil y adorable', '001-0001-00015', 'Hembra'),
('12345678P', 'Rocky Jr.', '2022-01-10', 'Boxer', 28.5, 58, 'Energético y protector', '001-0001-00016', 'Macho'),
('12345678Q', 'Lola', '2020-08-05', 'Bulldog Francés', 12.9, 30, 'Amistosa y juguetona', '001-0001-00017', 'Hembra'),
('12345678R', 'Bruno', '2019-04-15', 'Boxer', 28.0, 59, 'Protector y leal', '001-0001-00018', 'Macho'),
('12345678S', 'Luna', '2020-11-30', 'Golden Retriever', 32.5, 58, 'Cariñosa y obediente', '001-0001-00019', 'Hembra'),
('12345678T', 'Simba', '2018-02-20', 'Rottweiler', 45.8, 68, 'Fuerte y leal', '001-0001-00020', 'Macho');

CREATE TABLE SERVICIOS (
    codigo VARCHAR(6) PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Precio DECIMAL(5,2) NOT NULL,
    Descripcion VARCHAR(200)
);

INSERT INTO SERVICIOS VALUES ('SVBE01', 'Baño y secado', 25.99, 'Baño completo con champú y secado adecuado.');
INSERT INTO SERVICIOS VALUES ('SVBE02', 'Corte de Pelo', 35.99, 'Corte de pelo según el estilo deseado o las necesidades de la raza. Incluye baño.');
INSERT INTO SERVICIOS VALUES ('SVBE03', 'Corte de Uñas', 9.99, 'Corte de uñas para mantenerlas en una longitud segura y cómoda.');
INSERT INTO SERVICIOS VALUES ('SVBE04', 'Limpieza de Oídos', 10.99, 'Limpieza suave y cuidadosa de los oídos para eliminar el exceso de cera.');
INSERT INTO SERVICIOS VALUES ('SVBE05', 'Limpieza Dental', 45.99, 'Limpieza dental para eliminar la acumulación de placa y sarro.');
INSERT INTO SERVICIOS VALUES ('SVBE06', 'Desenredado', 20.99, 'Eliminación de nudos y cepillado del pelo para mantenerlo suave y saludable. Incluye baño en seco.');
INSERT INTO SERVICIOS VALUES ('SVBE07', 'Tratamiento Spa Premium', 55.99, 'Baño turco, aromaterapia y masaje.');
INSERT INTO SERVICIOS VALUES ('SVBE08', 'Tratamiento Spa Basic', 45.99, 'Baño turco y masaje.');
INSERT INTO SERVICIOS VALUES ('SVBE10', 'Spa Terapeutico', 75.99, 'Baño turco y masaje.');
INSERT INTO SERVICIOS VALUES ('SVBE09', 'Tintes', 40.99, 'Servicio de teñido de pelo utilizando tintes seguros para animales.');
INSERT INTO SERVICIOS VALUES ('SVNUT1', 'Consulta inicial Nutricion', 30.00, 'Toma de datos, diagnóstico inicial y régimen personalizado.');
INSERT INTO SERVICIOS VALUES ('SVNUT2', 'Consulta de mantenimiento', 20.00, 'Toma de medidas, evaluación y cambio de dieta.');

-- Crear tabla EMPLEADOS
CREATE TABLE EMPLEADOS (
    DNI VARCHAR(20) PRIMARY KEY,
    NOMBRE VARCHAR(20),
    APELLIDO1 VARCHAR(15),
    APELLIDO2 VARCHAR(15),
    CALLE VARCHAR(20),
    NUMERO INT,
    CP VARCHAR(5),
    POBLACION VARCHAR(50),
    PROVINCIA VARCHAR(20),
    TLFNO VARCHAR(20),
    PROFESION VARCHAR(20),
    ESPECIALIDAD VARCHAR(20),
    COD_REPRESENTANTE VARCHAR(20)
);

-- Insertar registros en la tabla EMPLEADOS
INSERT INTO EMPLEADOS (
    DNI, NOMBRE, APELLIDO1, APELLIDO2, CALLE, NUMERO, CP, 
    POBLACION, PROVINCIA, TLFNO, PROFESION, ESPECIALIDAD, COD_REPRESENTANTE
) VALUES
('12345678A', 'Juan', 'García', 'López', 'Calle Mayor', 10, '28001', 'Madrid', 'Madrid', '912345678', 'Ingeniero', 'Software', 'REP001'),
('23456789B', 'Ana', 'Martínez', 'Sánchez', 'Calle Gran Vía', 20, '28013', 'Madrid', 'Madrid', '913456789', 'Arquitecta', 'Diseño', 'REP002'),
('34567890C', 'Carlos', 'Rodríguez', 'Fernández', 'Calle Alcalá', 30, '28009', 'Madrid', 'Madrid', '914567890', 'Médico', 'Cardiología', 'REP003'),
('45678901D', 'Laura', 'Hernández', 'Gómez', 'Calle Princesa', 40, '28008', 'Madrid', 'Madrid', '915678901', 'Abogada', 'Penal', 'REP004'),
('56789012E', 'Miguel', 'López', 'Díaz', 'Calle Serrano', 50, '28006', 'Madrid', 'Madrid', '916789012', 'Profesor', 'Matemáticas', 'REP005'),
('67890123F', 'Sofía', 'Gómez', 'Martín', 'Calle Velázquez', 60, '28010', 'Madrid', 'Madrid', '917890123', 'Diseñadora', 'Gráfico', 'REP006'),
('78901234G', 'David', 'Fernández', 'Pérez', 'Calle Goya', 70, '28004', 'Madrid', 'Madrid', '918901234', 'Ingeniero', 'Civil', 'REP007'),
('89012345H', 'Elena', 'Pérez', 'Ruiz', 'Calle Castellana', 80, '28046', 'Madrid', 'Madrid', '919012345', 'Psicóloga', 'Clínica', 'REP008'),
('90123456I', 'Pablo', 'Sánchez', 'Jiménez', 'Calle Recoletos', 90, '28001', 'Madrid', 'Madrid', '910123456', 'Consultor', 'Negocios', 'REP009'),
('01234567J', 'Lucía', 'González', 'Moreno', 'Calle Ortega y Gasset', 100, '28006', 'Madrid', 'Madrid', '911234567', 'Periodista', 'Investigación', 'REP010'),
('12345678K', 'Marta', 'Díaz', 'Álvarez', 'Calle Orense', 110, '28020', 'Madrid', 'Madrid', '912345678', 'Ingeniera', 'Mecánica', 'REP011'),
('23456789L', 'Javier', 'Álvarez', 'Romero', 'Calle Príncipe de Vergara', 120, '28002', 'Madrid', 'Madrid', '913456789', 'Abogado', 'Laboral', 'REP012'),
('34567890M', 'Carmen', 'Romero', 'Serrano', 'Calle Génova', 130, '28004', 'Madrid', 'Madrid', '914567890', 'Médica', 'Pediatría', 'REP013'),
('45678901N', 'Alberto', 'Serrano', 'Torres', 'Calle Zurbano', 140, '28010', 'Madrid', 'Madrid', '915678901', 'Profesor', 'Historia', 'REP014'),
('56789012O', 'Isabel', 'Torres', 'Navarro', 'Calle Claudio Coello', 150, '28001', 'Madrid', 'Madrid', '916789012', 'Diseñadora', 'Interiores', 'REP015'),
('67890123P', 'Raúl', 'Navarro', 'Rubio', 'Calle Lagasca', 160, '28006', 'Madrid', 'Madrid', '917890123', 'Ingeniero', 'Eléctrico', 'REP016'),
('78901234Q', 'Patricia', 'Rubio', 'Molina', 'Calle Jorge Juan', 170, '28009', 'Madrid', 'Madrid', '918901234', 'Abogada', 'Civil', 'REP017'),
('89012345R', 'Sergio', 'Molina', 'Ortega', 'Calle Martínez Campos', 180, '28010', 'Madrid', 'Madrid', '919012345', 'Consultor', 'Tecnología', 'REP018'),
('90123456S', 'Natalia', 'Ortega', 'Vega', 'Calle Ayala', 190, '28001', 'Madrid', 'Madrid', '910123456', 'Psicóloga', 'Educativa', 'REP019'),
('01234567T', 'Hugo', 'Vega', 'Sanz', 'Calle Velázquez', 200, '28006', 'Madrid', 'Madrid', '911234567', 'Periodista', 'Cultura', 'REP020');


CREATE TABLE PERRO_RECIBE_SER (
    sr_cod INT PRIMARY KEY AUTO_INCREMENT,
    cod_servicio VARCHAR(6) NOT NULL,
    ID_Perro INT,
    Fecha DATE NOT NULL,
    Incidencias VARCHAR(400),
    Precio_final DECIMAL(5,2) NOT NULL,
    Dni VARCHAR(9) NOT NULL,
    FOREIGN KEY (Dni) REFERENCES EMPLEADOS(Dni),
    FOREIGN KEY (cod_servicio) REFERENCES SERVICIOS(Codigo),
    FOREIGN KEY (ID_Perro) REFERENCES PERROS(ID_Perro)
);

