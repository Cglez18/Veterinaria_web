DROP DATABASE IF EXISTS Veterinaria;
CREATE DATABASE Veterinaria;
USE Veterinaria;

CREATE TABLE Propietario (
    id_Prop INT PRIMARY KEY AUTO_INCREMENT,
    nom_Prop VARCHAR(100) NOT NULL,
    direc_Prop VARCHAR(255),
    tel_Prop VARCHAR(20) NOT NULL,
    mail_Prop VARCHAR(100) NOT NULL
);


CREATE TABLE Mascota (
    id_Mas INT PRIMARY KEY AUTO_INCREMENT,
    nom_Mas VARCHAR(15) NOT NULL,
    esp_Mas VARCHAR(15) NOT NULL,
    raz_Mas VARCHAR(30) NOT NULL,
    edad_Mas INT NOT NULL,
    sex_Mas VARCHAR(10) NOT NULL,
    pes_Mas FLOAT NOT NULL,
    id_Prop INT NOT NULL,
    FOREIGN KEY (id_Prop) REFERENCES Propietario(id_Prop)
);


CREATE TABLE Consulta (
    id_Consul INT PRIMARY KEY AUTO_INCREMENT,
    id_Mas INT NOT NULL,
    fecha_Consul VARCHAR(10) NOT NULL,
    hora_Consul VARCHAR(5) NOT NULL,
    diag_Consul VARCHAR(255) NOT NULL,
    trat_Consul VARCHAR(200) NOT NULL,
    prox_Consul VARCHAR(10),
    tipo_Consul VARCHAR(15),
    FOREIGN KEY (id_Mas) REFERENCES Mascota(id_Mas)
);

CREATE TABLE Producto (
    id_Producto INT PRIMARY KEY AUTO_INCREMENT,
    nom_Producto VARCHAR(50) NOT NULL,
    cost_Producto FLOAT NOT NULL,
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE Pago (
    id_Pago INT PRIMARY KEY AUTO_INCREMENT,
    mont_Pago INT NOT NULL,
    fecha_Pago VARCHAR(10) NOT NULL,
    id_Producto INT NOT NULL,
    FOREIGN KEY (id_Producto) REFERENCES Producto(id_Producto)
);

CREATE TABLE Prescripcion (
    id_Presc INT PRIMARY KEY AUTO_INCREMENT,
    id_Consul INT NOT NULL,
    id_Pago INT NOT NULL,
    FOREIGN KEY (id_Consul) REFERENCES Consulta(id_Consul),
    FOREIGN KEY (id_Pago) REFERENCES Pago(id_Pago)
);


CREATE TABLE Comida (
    id_Producto INT PRIMARY KEY,
    tipo_Comida VARCHAR(50) NOT NULL,
    vida_Comida VARCHAR(10) NOT NULL,
    especie_Comida VARCHAR(10) NOT NULL,
    FOREIGN KEY (id_Producto) REFERENCES Producto(id_Producto)
);

CREATE TABLE Medicina (
    id_Producto INT PRIMARY KEY,
    fvenci_Medicina VARCHAR(10) NOT NULL,
    pres_Medicina VARCHAR(15) NOT NULL,
    admin_Medicina VARCHAR(15) NOT NULL,
    especie_Medicina VARCHAR(15) NOT NULL,
    tipo_Medicina VARCHAR(15) NOT NULL,
    fabri_Medicina VARCHAR(15) NOT NULL,
    FOREIGN KEY (id_Producto) REFERENCES Producto(id_Producto)
);

CREATE TABLE Accesorios (
    id_Producto INT PRIMARY KEY,
    tipo_Accesorio VARCHAR(20) NOT NULL,
    mate_Accesorio VARCHAR(15) NOT NULL,
    talla_Accesorio VARCHAR(7),
    descrip_Accesorio VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_Producto) REFERENCES Producto(id_Producto)
);
