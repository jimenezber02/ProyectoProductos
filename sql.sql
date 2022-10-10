CREATE DATABASE IF NOT EXISTS abarroteria;
CREATE TABLE IF NOT EXISTS abarroteria.productos(
    id INT(5) NOT NULL AUTO_INCREMENT,
    codigo VARCHAR(30) NOT NULL,
    nombre VARCHAR(20) NOT NULL,
    descripcion VARCHAR(20) NOT NULL,
    precio FLOAT(7) NOT NULL,
    itbms INT(5) NOT NULL,
    stock INT NULL,
    id_categoria INT(10) NOT NULL,
    PRIMARY KEY(id)
); 

CREATE TABLE IF NOT EXISTS abarroteria.clientes(
    id_cli INT(20) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cedula VARCHAR(50),
    CONSTRAINT pk1 PRIMARY KEY(id_cli)
); 

CREATE TABLE IF NOT EXISTS abarroteria.cuentas_p_cobrar(
    id_cuentxcobrar INT(20) NOT NULL AUTO_INCREMENT,
    cuenta FLOAT(20) NOT NULL,
    id_cli INT(20) NOT NULL,
    CONSTRAINT pk2 PRIMARY KEY(id_cuentxcobrar),
    CONSTRAINT fk1 FOREIGN KEY(id_cli) REFERENCES clientes(id_cli)
); 

CREATE TABLE IF NOT EXISTS abarroteria.pedidos(
    id_ped INT(20) NOT NULL AUTO_INCREMENT,
    fecha VARCHAR(20) NOT NULL,
    anio VARCHAR(4),
    mes VARCHAR(10),
    diaS VARCHAR(12),
    dia INT(2),
    valor FLOAT(20) NOT NULL,
    estado VARCHAR(14) NOT NULL,
    comentario VARCHAR(120),
    id_cuentxcobrar INT(20) NOT NULL,
    PRIMARY KEY(id_ped),
    FOREIGN KEY(id_cuentxcobrar) REFERENCES cuentas_p_cobrar(id_cuentxcobrar)
); 

CREATE TABLE IF NOT EXISTS abarroteria.categoria_producto(
    id INT(5) NOT NULL AUTO_INCREMENT,
    categoria VARCHAR(20) NOT NULL,
    PRIMARY KEY(id)
); 

CREATE TABLE IF NOT EXISTS abarroteria.deuda_anteriores(
    id INT(5) NOT NULL AUTO_INCREMENT,
    monto FLOAT(7) NOT NULL,
    id_cuentxcobrar INT(20) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(id_cuentxcobrar) REFERENCES cuentas_p_cobrar(id_cuentxcobrar)
); 

CREATE TABLE IF NOT EXISTS abarroteria.saldos(
    id INT(5) NOT NULL AUTO_INCREMENT,
    monto FLOAT(7),
    id_cli INT(20) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(id_cli) REFERENCES clientes(id_cli)
);

INSERT INTO abarroteria.categoria_producto(categoria) VALUES
				('Granos'),
				('cafe'),
				('calzados'),
				('Enlatados'),
				('Galletas'),
				('Confites'),
				('Refrescos'),
				('Carnes'),
				('Detergentes'),
				('Escolar'),
				('Aseo'),
				('Especias'),
				('Pan'),
				('Medicamentos'),
				('Telas'),
				('Harina'),
				('Fideos'),
    			('otros');