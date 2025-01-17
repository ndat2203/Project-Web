﻿CREATE DATABASE QLBH
USE QLBH


CREATE TABLE KHACHHANG (
	MAKH int primary key,
	HOTEN nvarchar(50) NOT NULL,
	GIOITINH nvarchar(5),
	DCHI nvarchar(50),
	SDT varchar(50) NOT NULL,
	EMAIL varchar(100)
)

CREATE TABLE NGUOIDUNG (
	MAND int primary key,
	TENND nvarchar(50) NOT NULL ,
	NGSINH smalldatetime,
	GIOITINH nvarchar(5),
	SDT char(50) NOT NULL ,
	DIACHI nvarchar(50),
	USERNAME char(50),
	PASS nvarchar(max),
	QTV bit NOT NULL DEFAULT (0),
	TTND bit NOT NULL DEFAULT(1),
	AVA varchar(max),
	MAIL varchar(100)
)

CREATE TABLE SANPHAM (
	MASP int primary key,
	TENSP nvarchar(50) NOT NULL,
	GIA int NOT NULL,
	MOTA nvarchar(max),
	HINHSP nvarchar(max),
	SL int NOT NULL,
	LOAISP nvarchar(50),
	SIZE nvarchar(50)
)

CREATE TABLE HOADON (
	SOHD int primary key,
	MAND varchar(50),
	MAKH varchar(50),
	NGHD smalldatetime NOT NULL,
	TRIGIA int  NOT NULL,
	KHUYENMAI int	
)

CREATE TABLE PHIEUNHAP (
	MAPN int primary key,
	MAND varchar(50),
	NGAYNHAP smalldatetime NOT NULL 
)

CREATE TABLE CTHD (
	SOHD int,
	MASP varchar(50),
	SL int NOT NULL,
	primary key(SOHD, MASP)
)

CREATE TABLE CTPN (
	MAPN int,
	MASP varchar(50),
	SL int NOT NULL,
	primary key(MAPN, MASP)
)

ALTER TABLE HOADON
ADD CONSTRAINT FK_KH_HD
FOREIGN KEY (MAKH) REFERENCES KHACHHANG(MAKH)

ALTER TABLE HOADON
ADD CONSTRAINT FK_HD_ND
FOREIGN KEY (MAND) REFERENCES NGUOIDUNG(MAND)

ALTER TABLE CTHD
ADD CONSTRAINT FK_CT_HD
FOREIGN KEY (SOHD) REFERENCES HOADON(SOHD)

ALTER TABLE CTHD
ADD CONSTRAINT FK_CT_SP
FOREIGN KEY (MASP) REFERENCES SANPHAM(MASP)

ALTER TABLE CTPN 
ADD CONSTRAINT FK_CN_SP
FOREIGN KEY (MASP) REFERENCES SANPHAM(MASP)

ALTER TABLE CTPN
ADD CONSTRAINT FK_CN_PN
FOREIGN KEY (MAPN) REFERENCES PHIEUNHAP(MAPN)

ALTER TABLE PHIEUNHAP
ADD CONSTRAINT FK_PN_ND
FOREIGN KEY (MAND) REFERENCES NGUOIDUNG(MAND)
GO




