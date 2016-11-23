CREATE SCHEMA SISIDANG;

CREATE TABLE MAHASISWA(
	npm CHAR(10) PRIMARY KEY NOT NULL,
	nama VARCHAR(100) NOT NULL,
	username VARCHAR(30) NOT NULL,
	password VARCHAR(20) NOT NULL,
	email VARCHAR(100) NOT NULL,
	email_alternatif VARCHAR(100),
	telepon VARCHAR(100),
	notelp VARCHAR(100)
);

CREATE TABLE TERM(
	tahun integer NOT NULL,
	semester integer NOT NULL,
	CONSTRAINT TERMPK
		PRIMARY KEY (tahun, semester)
);

CREATE TABLE PRODI(
	ID integer PRIMARY KEY NOT NULL,
	NamaProdi VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE DOSEN(
	NIP VARCHAR(20) PRIMARY KEY NOT NULL,
	nama VARCHAR(100) NOT NULL,
	username VARCHAR(50) NOT NULL,
	password VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	institusi VARCHAR(100) NOT NULL
);

CREATE TABLE JENISMKS(
	ID INTEGER NOT NULL PRIMARY KEY,
	NamaMKS VARCHAR(50) UNIQUE NOT NULL
);

	
CREATE TABLE MATA_KULIAH_SPESIAL(
	IdMKS integer NOT NULL UNIQUE,
	NPM CHAR(10) REFERENCES MAHASISWA(npm) ON DELETE CASCADE ON UPDATE CASCADE,
	Tahun integer NOT NULL,
	Semester integer NOT NULL,
	Judul VARCHAR(250) NOT NULL,
	IsSiapSidang BOOLEAN DEFAULT FALSE,
	PengumpulanHardCopy BOOLEAN DEFAULT FALSE,
	IjinMajuSidang BOOLEAN DEFAULT FALSE,
	IdJenisMKS integer NOT NULL REFERENCES JENISMKS(ID) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(IdMKS, NPM, Tahun, Semester),
	FOREIGN KEY (tahun,semester) REFERENCES TERM (tahun,semester) ON DELETE RESTRICT ON UPDATE RESTRICT

);

CREATE TABLE DOSEN_PEMBIMBING(
	IDMKS integer REFERENCES MATA_KULIAH_SPESIAL(IdMKS) ON DELETE CASCADE ON UPDATE CASCADE,
	NIPdosenpembimbing VARCHAR(20) REFERENCES DOSEN(NIP) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY(IDMKS, NIPdosenpembimbing)
);

CREATE table DOSEN_PENGUJI(
    idmks integer not null,
    nipdosenpenguji varchar(20) not null,
    PRIMARY KEY (idmks, nipdosenpenguji),
    FOREIGN KEY (idmks) REFERENCES
        MATA_KULIAH_SPESIAL (idmks) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (nipdosenpenguji) REFERENCES
        DOSEN (nip) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE table SARAN_DOSEN_PENGUJI(
    idmks integer not null,
    NIPsaranpenguji varchar(20) not null,
    PRIMARY KEY (idmks, NIPsaranpenguji),
    FOREIGN KEY (idmks) REFERENCES
        MATA_KULIAH_SPESIAL (idmks) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (NIPsaranpenguji) REFERENCES
        DOSEN (nip) ON DELETE RESTRICT ON UPDATE RESTRICT
);


CREATE table TIMELINE(
    idTimeline Integer not null,
    namaEvent varchar(100) not null,
    tanggal date not null,
    tahun integer not null,
    semester integer not null,
    PRIMARY KEY (idTimeline),
    FOREIGN KEY (tahun,semester) REFERENCES
        TERM (tahun,semester) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE table JADWAL_NON_SIDANG(
    idJadwal integer not null,
    tanggalMulai date not null,
    tanggalSelesai date not null,
    alasan varchar(100) not null,
    repetisi varchar(50),
    nipDosen varchar(10) not null,

    PRIMARY KEY (idJadwal),
    FOREIGN KEY (nipDosen) REFERENCES
        DOSEN (nip) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE table RUANGAN(
    idRuangan integer not null PRIMARY KEY,
    namaRuangan varchar(20) not null UNIQUE
);

CREATE table JADWAL_SIDANG(
    idJadwal integer not null,
    idmks integer not null,
    tanggal date not null,
    jamMulai time not null,
    jamSelesai time not null,
    idRuangan int not null,
    PRIMARY KEY (idJadwal, idmks),
    FOREIGN KEY (idmks) REFERENCES
        MATA_KULIAH_SPESIAL (idmks) ON DELETE RESTRICT ON UPDATE RESTRICT,
    FOREIGN KEY (idRuangan) REFERENCES
        RUANGAN (idRuangan) ON DELETE RESTRICT ON UPDATE RESTRICT
);

CREATE table BERKAS(
    idBerkas integer not null,
    idmks integer not null,
    nama varchar(100) not null,
    alamat varchar(100) not null,

    PRIMARY KEY (idBerkas, idmks),
    FOREIGN KEY (idmks) REFERENCES
        MATA_KULIAH_SPESIAL (idmks) ON DELETE RESTRICT ON UPDATE RESTRICT
);
