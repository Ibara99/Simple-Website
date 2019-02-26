
create table admin 
(
   NAMA_ADMIN           varchar(30),
   KATA_SANDI           varchar(64),
   primary key (NAMA_ADMIN)
);

INSERT INTO admin VALUES('admin', SHA2('1234',0));

create table customer 
(
   USERNAME             varchar(30),
   PASSWORD             varchar(64),
   NAMA_LENGKAP			varchar(30),
   JENIS_KELAMIN        varchar(20),
   ALAMAT               varchar(60),
   NO_TELEPON           varchar(15),
   EMAIL                varchar(30),
   primary key (USERNAME)
);


create table rekening 
(
   NO_REKENING          integer ,
   USERNAME             varchar(30),
   SALDO                varchar(50),
   primary key (NO_REKENING),
   Foreign Key (USERNAME) REFERENCES customer (USERNAME)
   ON UPDATE CASCADE ON DELETE RESTRICT
);

create table transaksi 
(
   ID_TRANSAKSI         integer AUTO_INCREMENT,
   NO_REKENING_PENGIRIM integer,
   NO_REKENING_TUJUAN   integer,
   NOMINAL              varchar(30),
   WAKTU_TRANSAKSI      timestamp,
   primary key (ID_TRANSAKSI),
   Foreign Key (NO_REKENING_PENGIRIM) REFERENCES rekening (NO_REKENING)
   ON UPDATE CASCADE ON DELETE RESTRICT,
   Foreign Key (NO_REKENING_TUJUAN) REFERENCES rekening (NO_REKENING)
   ON UPDATE CASCADE ON DELETE RESTRICT
   
);
