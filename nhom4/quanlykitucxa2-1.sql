-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 04, 2024 lúc 09:48 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlykitucxa`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `HoaDon`
--

CREATE TABLE `HoaDon` (
  `HoaDonID` int(11) NOT NULL,
  `HopDongID` int(11) DEFAULT NULL,
  `SoDien` int(11) DEFAULT NULL,
  `SoNuoc` int(11) DEFAULT NULL,
  `NgayLap` date DEFAULT NULL,
  `TongTien` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `HopDong`
--

CREATE TABLE `HopDong` (
  `HopDongID` int(11) NOT NULL,
  `SinhVienID` int(11) DEFAULT NULL,
  `QuanLyID` int(11) DEFAULT NULL,
  `PhongID` int(11) DEFAULT NULL,
  `NgayThue` date DEFAULT NULL,
  `NgayTra` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `HopDong`
--

INSERT INTO `HopDong` (`HopDongID`, `SinhVienID`, `QuanLyID`, `PhongID`, `NgayThue`, `NgayTra`) VALUES
(9, 1, 1, 1, '2024-06-01', '2024-07-01'),
(10, 2, 1, 1, '2024-06-01', '2024-07-01'),
(11, 17, 1, 1, '2024-06-01', '2024-07-01'),
(12, 5, 1, 4, '2024-06-01', '2024-08-01'),
(13, 6, 1, 4, '2024-06-01', '2024-09-01'),
(14, 3, 1, 2, '2024-06-01', '2024-08-01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `KhuVuc`
--

CREATE TABLE `KhuVuc` (
  `KhuVucID` int(11) NOT NULL,
  `TenKhuVuc` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `KhuVuc`
--

INSERT INTO `KhuVuc` (`KhuVucID`, `TenKhuVuc`) VALUES
(1, 'Nam'),
(2, 'Nữ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `LoaiPhong`
--

CREATE TABLE `LoaiPhong` (
  `LoaiPhongID` int(11) NOT NULL,
  `TenLoaiPhong` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `LoaiPhong`
--

INSERT INTO `LoaiPhong` (`LoaiPhongID`, `TenLoaiPhong`) VALUES
(1, '4'),
(2, '6'),
(3, '8');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Phong`
--

CREATE TABLE `Phong` (
  `PhongID` int(11) NOT NULL,
  `TenPhong` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `KhuVucID` int(11) DEFAULT NULL,
  `LoaiPhongID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `Phong`
--

INSERT INTO `Phong` (`PhongID`, `TenPhong`, `KhuVucID`, `LoaiPhongID`) VALUES
(1, 'p1', 1, 1),
(2, 'p2', 1, 2),
(3, 'p3', 1, 3),
(4, 'p4', 2, 1),
(5, 'p5', 2, 2),
(6, 'p6', 2, 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `QuanLy`
--

CREATE TABLE `QuanLy` (
  `QuanLyID` int(11) NOT NULL,
  `HoTen` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `GioiTinh` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `NgaySinh` date DEFAULT NULL,
  `DienThoai` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `QuanLy`
--

INSERT INTO `QuanLy` (`QuanLyID`, `HoTen`, `GioiTinh`, `NgaySinh`, `DienThoai`) VALUES
(1, 'Phan Văn Vinh', 'Nam', '1992-05-09', '0929760418'),
(2, 'Lê Thị Lan', 'Nữ', '1980-07-06', '0965318742'),
(3, 'Nguyễn Văn Long', 'Nam', '1975-08-04', '0943092658'),
(4, 'Quách Văn Bảo', 'Nam', '1980-08-04', '0912857439'),
(5, 'Châu Thị Cẩm', 'Nữ', '1996-03-12', '0959423167');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `SinhVien`
--

CREATE TABLE `SinhVien` (
  `SinhVienID` int(11) NOT NULL,
  `HoTen` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `GioiTinh` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `NgaySinh` date DEFAULT NULL,
  `QueQuan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `DienThoai` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `SinhVien`
--

INSERT INTO `SinhVien` (`SinhVienID`, `HoTen`, `GioiTinh`, `NgaySinh`, `QueQuan`, `DienThoai`) VALUES
(1, 'Mã Trường Bảo', 'Nam', '2002-12-15', 'TP.HCM', '0933670135'),
(2, 'Nguyễn Văn Đức', 'Nam', '2002-04-22', 'TP.HCM', '0956465487'),
(3, 'Đặng Văn Hải', 'Nam', '1998-04-09', 'An Giang', '0369852147'),
(4, 'Võ Anh Vũ', 'Nam', '2002-11-28', 'TP.HCM', '0369852147'),
(5, 'Lê Thị Hương', 'Nữ', '2002-07-08', 'Cà Mau', '0936251489'),
(6, 'Lý Thị Huệ', 'Nữ', '2001-05-04', 'Long An', '0969783524'),
(7, 'Nguyễn Thị Thúy', 'Nữ', '2002-08-08', 'Phú Yên', '0945897321'),
(8, 'Nguyễn Thị Hòa', 'Nữ', '2002-08-20', 'Tây Ninh', '0987654321'),
(9, 'Nguyễn Thị Tuyết', 'Nữ', '2002-05-08', 'Sa Đéc', '0956941327'),
(10, 'Phạm Văn Hưng', 'Nam', '2002-05-16', 'Tiền Giang', '0998012457'),
(11, 'Trương Văn Huy', 'Nam', '2003-11-05', 'TP.HCM', '0983021694'),
(12, 'Lê Văn Thắng', 'Nam', '2003-10-17', 'Long An', '0921345678'),
(13, 'Phạm Thị Thảo', 'Nữ', '2001-03-30', 'Tây Ninh', '0978903124'),
(14, 'Đỗ Văn Thuận', 'Nam', '2000-02-15', 'TP.HCM', '0964578219'),
(15, 'Nguyễn Văn Tuấn', 'Nam', '2004-12-07', 'Bình Thuận', '0837218956'),
(16, 'Trần Thị Trang', 'Nữ', '2005-01-04', 'Sóc Trăng', '0918479023'),
(17, 'Lê Văn Trung', 'Nam', '2004-09-06', 'Bến Tre', '0973562918'),
(18, 'Nguyễn Thị Tuyết', 'Nữ', '2003-12-23', 'Quãng Nam', '0956941327'),
(19, 'Trần Văn Tâm', 'Nam', '2001-08-27', 'Tây Ninh', '0934187295'),
(20, 'Võ Thị Vy', 'Nữ', '2003-10-04', 'Vũng Tàu', '0981234567');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `HoaDon`
--
ALTER TABLE `HoaDon`
  ADD PRIMARY KEY (`HoaDonID`),
  ADD KEY `HopDongID` (`HopDongID`);

--
-- Chỉ mục cho bảng `HopDong`
--
ALTER TABLE `HopDong`
  ADD PRIMARY KEY (`HopDongID`),
  ADD KEY `SinhVienID` (`SinhVienID`),
  ADD KEY `QuanLyID` (`QuanLyID`),
  ADD KEY `PhongID` (`PhongID`);

--
-- Chỉ mục cho bảng `KhuVuc`
--
ALTER TABLE `KhuVuc`
  ADD PRIMARY KEY (`KhuVucID`);

--
-- Chỉ mục cho bảng `LoaiPhong`
--
ALTER TABLE `LoaiPhong`
  ADD PRIMARY KEY (`LoaiPhongID`);

--
-- Chỉ mục cho bảng `Phong`
--
ALTER TABLE `Phong`
  ADD PRIMARY KEY (`PhongID`),
  ADD KEY `KhuVucID` (`KhuVucID`),
  ADD KEY `LoaiPhongID` (`LoaiPhongID`);

--
-- Chỉ mục cho bảng `QuanLy`
--
ALTER TABLE `QuanLy`
  ADD PRIMARY KEY (`QuanLyID`);

--
-- Chỉ mục cho bảng `SinhVien`
--
ALTER TABLE `SinhVien`
  ADD PRIMARY KEY (`SinhVienID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `HoaDon`
--
ALTER TABLE `HoaDon`
  MODIFY `HoaDonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `HopDong`
--
ALTER TABLE `HopDong`
  MODIFY `HopDongID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `KhuVuc`
--
ALTER TABLE `KhuVuc`
  MODIFY `KhuVucID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `LoaiPhong`
--
ALTER TABLE `LoaiPhong`
  MODIFY `LoaiPhongID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `Phong`
--
ALTER TABLE `Phong`
  MODIFY `PhongID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `QuanLy`
--
ALTER TABLE `QuanLy`
  MODIFY `QuanLyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `SinhVien`
--
ALTER TABLE `SinhVien`
  MODIFY `SinhVienID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `HoaDon`
--
ALTER TABLE `HoaDon`
  ADD CONSTRAINT `hoadon_ibfk_1` FOREIGN KEY (`HopDongID`) REFERENCES `HopDong` (`HopDongID`);

--
-- Các ràng buộc cho bảng `HopDong`
--
ALTER TABLE `HopDong`
  ADD CONSTRAINT `hopdong_ibfk_1` FOREIGN KEY (`SinhVienID`) REFERENCES `SinhVien` (`SinhVienID`),
  ADD CONSTRAINT `hopdong_ibfk_2` FOREIGN KEY (`QuanLyID`) REFERENCES `QuanLy` (`QuanLyID`),
  ADD CONSTRAINT `hopdong_ibfk_3` FOREIGN KEY (`PhongID`) REFERENCES `Phong` (`PhongID`);

--
-- Các ràng buộc cho bảng `Phong`
--
ALTER TABLE `Phong`
  ADD CONSTRAINT `phong_ibfk_1` FOREIGN KEY (`KhuVucID`) REFERENCES `KhuVuc` (`KhuVucID`),
  ADD CONSTRAINT `phong_ibfk_2` FOREIGN KEY (`LoaiPhongID`) REFERENCES `LoaiPhong` (`LoaiPhongID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
