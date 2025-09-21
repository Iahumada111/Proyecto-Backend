-- ===== Creación de tablas =====
CREATE TABLE Usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    correo VARCHAR(150) UNIQUE,
    contraseña VARCHAR(255),
    rol ENUM('docente','estudiante','coordinador')
);

CREATE TABLE Estudiante (
    id_estudiante INT PRIMARY KEY,
    matricula VARCHAR(50) UNIQUE,
    grupo VARCHAR(50),
    estado ENUM('activo','inactivo'),
    FOREIGN KEY (id_estudiante) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Docente (
    id_docente INT PRIMARY KEY,
    codigo_docente VARCHAR(50) UNIQUE,
    especialidad VARCHAR(100),
    FOREIGN KEY (id_docente) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Coordinador (
    id_coordinador INT PRIMARY KEY,
    area_asignada VARCHAR(100),
    FOREIGN KEY (id_coordinador) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Curso (
    id_curso INT PRIMARY KEY AUTO_INCREMENT,
    nombre_curso VARCHAR(150),
    descripcion TEXT,
    id_docente INT,
    FOREIGN KEY (id_docente) REFERENCES Docente(id_docente)
);

CREATE TABLE Clase (
    id_clase INT PRIMARY KEY AUTO_INCREMENT,
    id_curso INT,
    fecha DATE,
    hora_inicio TIME,
    hora_fin TIME,
    FOREIGN KEY (id_curso) REFERENCES Curso(id_curso)
);

CREATE TABLE Asistencia (
    id_asistencia INT PRIMARY KEY AUTO_INCREMENT,
    id_clase INT,
    id_estudiante INT,
    estado ENUM('presente','ausente','tarde','justificado'),
    justificacion TEXT,
    aprobada BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_clase) REFERENCES Clase(id_clase),
    FOREIGN KEY (id_estudiante) REFERENCES Estudiante(id_estudiante)
);

CREATE TABLE Notificacion (
    id_notificacion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    mensaje TEXT,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    leida BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- la tabla: Inscripción (vincula estudiantes con cursos)
CREATE TABLE Inscripcion (
    id_inscripcion INT PRIMARY KEY AUTO_INCREMENT,
    id_curso INT,
    id_estudiante INT,
    fecha_inscripcion DATE,
    estado ENUM('activo','retirado') DEFAULT 'activo',
    FOREIGN KEY (id_curso) REFERENCES Curso(id_curso),
    FOREIGN KEY (id_estudiante) REFERENCES Estudiante(id_estudiante)
);

-- ===== Datos de prueba =====
INSERT INTO Usuario (nombre, apellido, correo, contraseña, rol) VALUES
('Ana', 'Martinez', 'ana.martinez@school.com', '1234', 'docente'),
('Carlos', 'Lopez', 'carlos.lopez@school.com', '1234', 'estudiante'),
('Maria', 'Gomez', 'maria.gomez@school.com', '1234', 'estudiante'),
('Luis', 'Perez', 'luis.perez@school.com', '1234', 'coordinador');

-- Docente (usa el id_usuario = 1)
INSERT INTO Docente (id_docente, codigo_docente, especialidad) VALUES 
(1, 'DOC001', 'Matemáticas');

-- Estudiantes (id_usuario = 2 y 3)
INSERT INTO Estudiante (id_estudiante, matricula, grupo, estado) VALUES 
(2, 'EST001', '3A', 'activo'),
(3, 'EST002', '3A', 'activo');

-- Coordinador
INSERT INTO Coordinador (id_coordinador, area_asignada) VALUES 
(4, 'Académica');

-- Curso (dictado por Ana, id_docente = 1)
INSERT INTO Curso (nombre_curso, descripcion, id_docente) VALUES 
('Álgebra', 'Curso de álgebra básica', 1),
('Geometría', 'Curso de geometría básica', 1);

-- Clases (sesiones)
INSERT INTO Clase (id_curso, fecha, hora_inicio, hora_fin) VALUES 
(1, '2025-09-15', '08:00', '09:00'),
(1, '2025-09-16', '08:00', '09:00'),
(2, '2025-09-15', '10:00', '11:00');

-- Inscripciones (vincula estudiantes con cursos) -> **nuevo**
INSERT INTO Inscripcion (id_curso, id_estudiante, fecha_inscripcion) VALUES
(1, 2, '2025-03-01'),
(1, 3, '2025-03-01'),
(2, 3, '2025-03-01'); -- Maria también inscrita en Geometría

-- Asistencias
INSERT INTO Asistencia (id_clase, id_estudiante, estado) VALUES 
(1, 2, 'presente'),  -- Carlos presente 15/09 en Álgebra
(1, 3, 'ausente');   -- Maria ausente 15/09 en Álgebra

INSERT INTO Asistencia (id_clase, id_estudiante, estado, justificacion, aprobada) VALUES 
(2, 3, 'justificado', 'Enfermedad con certificado médico', TRUE); -- Maria justificada 16/09

-- Notificaciones
INSERT INTO Notificacion (id_usuario, mensaje) VALUES 
(3, 'Tu inasistencia del 15/09 fue registrada como ausente.'),
(3, 'Tu justificación del 16/09 fue aprobada por el coordinador.');