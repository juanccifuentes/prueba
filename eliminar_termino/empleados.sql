CREATE TABLE empleados (   
		idempleado int NOT NULL auto_increment,
		nombres varchar(32) NOT NULL,
		departamento varchar(40)NOT NULL,
		sueldo double,
		KEY id(idempleado) ) 
TYPE=MyISAM;    


INSERT INTO empleados VALUES (1, 'Juan Perez', 'Informatica',500.00);
INSERT INTO empleados VALUES (2, 'Laura Morales', 'Contabilidad',550.00);
INSERT INTO empleados VALUES (3, 'Luis Gutierrez', 'Administracion',850.00);
INSERT INTO empleados VALUES (4, 'Pedro Solar', 'Informatica',500.00);
INSERT INTO empleados VALUES (5, 'David Vilchez', 'Contabilidad',550.00);