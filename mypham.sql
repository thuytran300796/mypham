-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 31, 2017 lúc 06:27 CH
-- Phiên bản máy phục vụ: 10.1.21-MariaDB
-- Phiên bản PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mypham`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `MaBL` varchar(20) NOT NULL,
  `MaKH` varchar(20) NOT NULL,
  `MaSP` varchar(50) NOT NULL,
  `Ngay` datetime NOT NULL,
  `NoiDung` text NOT NULL,
  `MaBLCha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`MaBL`, `MaKH`, `MaSP`, `Ngay`, `NoiDung`, `MaBLCha`) VALUES
('BL1', 'thuytran3007', 'CST_TinhDau_Milaganis', '2017-12-07 23:12:35', 'Son lên màu đẹp... nhưng mau trôi quá<br />\nAhihi', ''),
('BL2', 'thuytran3007', 'CST_TinhDau_Milaganis', '2017-12-07 23:39:56', 'Binh luan duoc roi... vui qua', ''),
('BL3', 'thuytran3007', 'CST_TinhDau_Milaganis', '2017-12-07 23:47:03', 'ddddddd', ''),
('BL4', 'thuytran3007', 'CST_TinhDau_Milaganis', '2017-12-07 23:48:07', 'sss', ''),
('BL5', 'tran3007', 'SRM_Senka', '2017-12-08 01:33:07', 'đây là Trân... ', ''),
('BL6', 'thuytran3007', 'SRM_Senka', '2017-12-11 00:54:27', 'ahihi', ''),
('BL7', 'thuytran3007', '7', '2017-12-30 02:37:37', 'son dep95', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietgiohang`
--

CREATE TABLE `chitietgiohang` (
  `MaGH` varchar(20) NOT NULL,
  `MaCTSP` varchar(50) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `MaKM` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `chitietgiohang`
--

INSERT INTO `chitietgiohang` (`MaGH`, `MaCTSP`, `SoLuong`, `MaKM`) VALUES
('GH1', 'CST_TinhDau_Milaganis_ct', 1, '000'),
('GH2', 'CST_TinhDau_Milaganis_ct', 1, '000'),
('GH3', 'Son_Maybe_BaMau_RD01', 1, '000'),
('GH4', 'Son_Maybe_BaMau_RD01', 1, '000'),
('GH5', 'SRM_Senka_ct', 2, '000'),
('GH6', 'SRM_Senka_ct', 1, '000'),
('GH7', '8', 1, 'KM2'),
('GH7', 'CST_TinhDau_Milaganis_ct', 1, 'KM3'),
('GH7', 'Son_Maybe_BaMau_RD01', 1, '000'),
('GH7', 'SRM_Senka_ct', 1, 'KM3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

CREATE TABLE `chitiethoadon` (
  `MaHD` varchar(20) NOT NULL,
  `MaCTSP` varchar(50) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `GiaBan` double NOT NULL,
  `MaKM` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`MaHD`, `MaCTSP`, `SoLuong`, `GiaBan`, `MaKM`) VALUES
('hd1', 'SON_Maybe_BaMau_PK01', 1, 105000, ''),
('hd2', 'SON_Maybe_BaMau_RD01', 2, 105000, ''),
('hd3', 'CST_TinhDau_Milaganis_ct', 4, 185000, ''),
('hd4', 'CST_TinhDau_Milaganis_ct', 1, 125000, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietluong`
--

CREATE TABLE `chitietluong` (
  `MaNV` varchar(20) NOT NULL,
  `Ngay` date NOT NULL,
  `Thuong` double NOT NULL,
  `Phat` double NOT NULL,
  `SoNgayCong` int(11) NOT NULL,
  `LuongCoBan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietsanpham`
--

CREATE TABLE `chitietsanpham` (
  `MaCTSP` varchar(50) NOT NULL,
  `MauSac` varchar(20) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `MaSP` varchar(50) NOT NULL,
  `GiaDeXuat` double NOT NULL,
  `GiaBan` double NOT NULL,
  `NgaySX` date NOT NULL,
  `HanSuDung` date NOT NULL,
  `MaNCC` varchar(20) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `chitietsanpham`
--

INSERT INTO `chitietsanpham` (`MaCTSP`, `MauSac`, `SoLuong`, `MaSP`, `GiaDeXuat`, `GiaBan`, `NgaySX`, `HanSuDung`, `MaNCC`, `TrangThai`) VALUES
('', '', -3, '', 0, 0, '0000-00-00', '0000-00-00', '', 0),
('10', 'PK02', 10, 'SON_Maybe_BaMau', 0, 185000, '2017-12-23', '2018-12-23', '', 1),
('5', 'Hồng neon', 9, 'SON_KEM_Riche', 0, 243000, '2017-12-23', '2019-12-23', '', 1),
('6', 'Cam', 5, 'SON_KEM_Riche', 0, 243000, '2017-12-23', '2019-12-23', '', 1),
('7', 'đỏ anh đào', 5, 'SON_KEM_Riche', 0, 243000, '2017-12-23', '2019-12-23', '', 1),
('8', 'Xám', 6, 'KeMay_MasterBrown', 0, 93000, '2016-06-19', '2018-01-23', '', 1),
('CST_TinhDau_Milaganis_ct', '', 14, 'CST_TinhDau_Milaganis', 108000, 108000, '2015-12-01', '2017-12-31', 'NCC1', 1),
('Son_Maybe_BaMau_PK01', 'PK01', 15, 'Son_Maybe_BaMau', 185000, 185000, '2017-12-06', '2020-12-26', 'NCC1', 1),
('Son_Maybe_BaMau_RD01', 'RD01', 5, 'Son_Maybe_BaMau', 190000, 190000, '2017-12-14', '2017-12-14', 'NCC2', 1),
('SRM_Senka_ct', '', 3, 'SRM_Senka', 85000, 85000, '2017-12-07', '2019-12-07', 'NCC2', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chucvu`
--

CREATE TABLE `chucvu` (
  `MaCV` varchar(20) NOT NULL,
  `TenCV` varchar(50) NOT NULL,
  `HeSoLuong` float NOT NULL,
  `PhuCap` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `chucvu`
--

INSERT INTO `chucvu` (`MaCV`, `TenCV`, `HeSoLuong`, `PhuCap`) VALUES
('admin', 'Người quản trị', 2.3, 20000),
('NVBH', 'Nhân viên bán hàng', 1.6, 50000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ctsp_km`
--

CREATE TABLE `ctsp_km` (
  `id` varchar(20) NOT NULL,
  `MaKM` varchar(20) NOT NULL,
  `MaCTSP` varchar(50) NOT NULL,
  `NgayBD` date NOT NULL,
  `NgayKT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `ctsp_km`
--

INSERT INTO `ctsp_km` (`id`, `MaKM`, `MaCTSP`, `NgayBD`, `NgayKT`) VALUES
('1', 'KM1', '', '2017-12-26', '2018-01-27'),
('12', 'KM6', '', '2017-12-29', '2017-12-30'),
('13', 'KM7', '10', '2017-12-30', '2017-12-30'),
('14', 'KM8', '', '2017-12-31', '2017-12-31'),
('15', 'KM3', '5', '2017-12-28', '2017-12-30'),
('16', 'KM3', 'CST_TinhDau_Milaganis_ct', '2017-12-28', '2017-12-30'),
('2', 'KM2', '', '2017-12-28', '2017-12-31'),
('8', 'KM4', '', '2017-12-28', '2017-12-29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDM` varchar(20) NOT NULL,
  `TenDM` varchar(50) NOT NULL,
  `MoTa` varchar(200) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL,
  `DMCha` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`MaDM`, `TenDM`, `MoTa`, `TrangThai`, `DMCha`) VALUES
('BB_CC', 'BB Cream - CC Cream', '', 1, 'TDFace'),
('CKD', 'Che khuyết điểm', '', 1, 'TDFace'),
('CSCT', 'Chăm sóc cơ thể', '', 1, ''),
('CSD', 'Chăm sóc da', '', 1, ''),
('CST', 'Chăm sóc tóc', '', 1, ''),
('DauGoi', 'Dầu gội', '', 1, 'CST'),
('DauXa', 'Dầu xả', '', 1, 'CST'),
('DGGau', 'Dầu gội trị gàu', '', 1, 'DauGoi'),
('DGKho', 'Dầu gội cho tóc khô', '', 1, 'DauGoi'),
('DGRungToc', 'Dầu gội trị rụng tóc', '', 1, 'DauGoi'),
('DT', 'Dưỡng tóc, ủ tóc', '', 1, 'CST'),
('HL_TaoKhoi', 'High Light - Tạo khối', '', 1, 'TDFace'),
('KCN', 'Kem chống nắng', '', 1, 'CSD'),
('KemDD', 'Kem dưỡng da', '', 1, 'CSD'),
('KemLot', 'Kem lót', '', 1, 'TDFace'),
('KemNen', 'Kem nền', '', 1, 'TDFace'),
('KMAT', 'Kẻ mắt', '', 1, 'TDMA'),
('KMAY', 'Kẻ mày', '', 1, 'TDMA'),
('MASCARA', 'Mascara', '', 1, 'TDMA'),
('MatNa', 'Mặt nạ', '', 1, 'CSD'),
('NH', 'Nước hoa', '', 1, ''),
('NHH', 'Nước hoa hồng', '', 1, 'CSD'),
('PhanMa', 'Má hồng', '', 1, 'TDFace'),
('PhanNen', 'Phấn nền', '', 1, 'TDFace'),
('PhanPhu', 'Phấn phủ', '', 1, 'TDFace'),
('PM', 'Phấn mắt', '', 1, 'TDMA'),
('SB', 'Son bóng', '', 1, 'TDM'),
('SD', 'Son dưỡng', '', 1, 'TDM'),
('SKem', 'Son kem', '', 1, 'TDM'),
('SonTint', 'Son Tint', '', 1, 'TDM'),
('SRM', 'Sữa rửa mặt', '', 1, 'CSD'),
('SThoi', 'Son thỏi', '', 1, 'TDM'),
('TD', 'Trang điểm', '', 1, ''),
('TDFace', 'Trang điểm mặt', '', 1, 'TD'),
('TDM', 'Trang điểm môi', '', 1, 'TD'),
('TDMA', 'Trang điểm mắt', '', 1, 'TD'),
('XitKhoang', 'Xịt khoáng', '', 1, 'CSD'),
('XK', 'Xịt khoáng', '', 1, 'CSD');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `MaGH` varchar(20) NOT NULL,
  `MaKH` varchar(20) NOT NULL,
  `NgayDat` datetime NOT NULL,
  `HoTenNguoiNhan` varchar(50) NOT NULL,
  `SDT` varchar(20) NOT NULL,
  `DiaChi` text NOT NULL,
  `NgayGiao` date NOT NULL,
  `TrangThai` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`MaGH`, `MaKH`, `NgayDat`, `HoTenNguoiNhan`, `SDT`, `DiaChi`, `NgayGiao`, `TrangThai`) VALUES
('GH1', '', '2017-12-15 00:46:17', 's', 's', 's', '0000-00-00', 1),
('GH2', 'thuytran3007', '2017-12-15 00:49:28', 'Trân Phạm', '0939614616', 'Q.Bình Thủy, TP.Cần Thơ', '2017-12-14', 1),
('GH3', 'thuytran3007', '2017-12-15 00:51:03', 'Trân Phạm', '0939614616', 'Q.Bình Thủy, TP.Cần Thơ', '0000-00-00', 1),
('GH4', 'thuytran3007', '2017-12-15 00:51:54', 'Trân Phạm', '0939614616', 'Q.Bình Thủy, TP.Cần Thơ', '0000-00-00', 1),
('GH5', 'thuytran3007', '2017-12-15 00:52:48', 'Trân Phạm', '0939614616', 'Q.Bình Thủy, TP.Cần Thơ', '0000-00-00', 1),
('GH6', 'thuytran3007', '2017-12-15 00:56:36', 'Trân Phạm', '0939614616', 'Q.Bình Thủy, TP.Cần Thơ', '0000-00-00', 1),
('GH7', 'thuytran3007', '2017-12-30 02:35:28', 'Trân Phạm', '0939614616', 'Q.Bình Thủy, TP.Cần Thơ', '2017-12-31', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhanh`
--

CREATE TABLE `hinhanh` (
  `MaHA` varchar(20) NOT NULL,
  `DuongDan` varchar(100) NOT NULL,
  `MaSP` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `hinhanh`
--

INSERT INTO `hinhanh` (`MaHA`, `DuongDan`, `MaSP`) VALUES
('HA1', '4901872444991.u2409.d20170103.t151444.42455.jpg', 'SRM_Senka'),
('HA2', '6902395449256_2.u2409.d20161024.t121001.348350.jpg', 'SON_Maybe_BaMau'),
('HA4', '6902395449256_3.u2409.d20161024.t121001.381429.jpg', 'SON_Maybe_BaMau'),
('HA5', 'td_buoi_21.jpg', 'CST_TinhDau_Milaganis'),
('HA6', 'color-riche-l-extraordinaire-matte_1_111.u2409.d20161109.t104913.926762.jpg', 'SON_KEM_Riche'),
('HA8', 'master_brow_liner_gy-1_1.jpg', 'KeMay_MasterBrown');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

CREATE TABLE `hoadon` (
  `MaHD` varchar(20) NOT NULL,
  `MaNV` varchar(20) NOT NULL,
  `NgayXuat` datetime NOT NULL,
  `MaKH` varchar(20) NOT NULL,
  `MaKM` varchar(20) NOT NULL,
  `ChietKhau` int(11) NOT NULL,
  `PhiVanChuyen` double NOT NULL,
  `Thue` int(11) NOT NULL,
  `HoTenNguoiNhan` varchar(50) NOT NULL,
  `SDT` varchar(20) NOT NULL,
  `DiaChi` text NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` varchar(20) NOT NULL,
  `TenKH` varchar(50) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` tinyint(1) NOT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `DiaChi` text NOT NULL,
  `HinhDaiDien` varchar(100) NOT NULL,
  `MatKhau` varchar(50) NOT NULL,
  `DiemTichLuy` int(11) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MaKH`, `TenKH`, `NgaySinh`, `GioiTinh`, `SoDienThoai`, `DiaChi`, `HinhDaiDien`, `MatKhau`, `DiemTichLuy`, `TrangThai`) VALUES
('', '', '0000-00-00', 0, '', '', '', '', 0, 0),
('thuytran3007', 'Trân Phạm', '1996-07-30', 0, '0939614616', 'Q.Bình Thủy, TP.Cần Thơ', '16730134_638942349645975_7650809397051739164_n.jpg', '202cb962ac59075b964b07152d234b70', 0, 1),
('tran3007', 'Thủy Trân', '1996-07-30', 0, '0939614616', 'Bình Thủy, Cần Thơ', '16700007_736167479867040_1149049724_n.jpg', '202cb962ac59075b964b07152d234b70', 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khuyenmai`
--

CREATE TABLE `khuyenmai` (
  `MaKM` varchar(20) NOT NULL,
  `NgayBatDau` date NOT NULL,
  `NgayKetThuc` date NOT NULL,
  `MoTa` text NOT NULL,
  `MaSP` varchar(50) NOT NULL,
  `ChietKhau` int(11) NOT NULL,
  `TienGiamGia` double NOT NULL,
  `GiaTriVoucher` double NOT NULL,
  `GiaTriDonHang` double NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `khuyenmai`
--

INSERT INTO `khuyenmai` (`MaKM`, `NgayBatDau`, `NgayKetThuc`, `MoTa`, `MaSP`, `ChietKhau`, `TienGiamGia`, `GiaTriVoucher`, `GiaTriDonHang`, `TrangThai`) VALUES
('000', '0000-00-00', '0000-00-00', '', '', 0, 0, 0, 0, 0),
('KM1', '0000-00-00', '0000-00-00', 'hello', '', 3, 0, 0, 100000, 0),
('KM2', '0000-00-00', '0000-00-00', '', 'SON_Maybe_BaMau', 5, 0, 0, 0, 1),
('KM3', '0000-00-00', '0000-00-00', '', 'SRM_Senka', 0, 0, 0, 0, 1),
('KM4', '0000-00-00', '0000-00-00', '', '', 0, 0, 20000, 100000, 0),
('KM6', '0000-00-00', '0000-00-00', '', '', 0, 10000, 0, 800000, 0),
('KM7', '0000-00-00', '0000-00-00', '', '', 0, 0, 0, 0, 0),
('KM8', '0000-00-00', '0000-00-00', '', '', 0, 0, 10000, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MaNCC` varchar(20) NOT NULL,
  `TenNCC` varchar(100) NOT NULL,
  `DiaChi` text CHARACTER SET utf32 NOT NULL,
  `SDT` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `GhiChu` varchar(200) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`MaNCC`, `TenNCC`, `DiaChi`, `SDT`, `Email`, `GhiChu`, `TrangThai`) VALUES
('NCC1', 'Công ty Minh Anh', 'Lê Hồng Phong, Trà Nóc, Bình Thủy, TP.Cần Thơ', '0939614616', 'mianh@gmai.com', 'test', 1),
('NCC14', 'Tí Beo', 'ô môn', '01222604616', 'tb@gmail.com', '', 1),
('NCC15', 'g', 'g', 'g', 'g', 'g', 0),
('NCC16', 'u', 'u', 'u', 'u', 'u', 0),
('NCC17', 'h', 'h', 'h', 'h', 'h', 0),
('NCC18', 'u', '', '', '', '', 0),
('NCC19', 'ten', 'diachi', 'sdt', 'email', 'ghichu', 1),
('NCC2', 'Nhà phân phối Thiên Trang', '30/4, Ninh Kiều, Tp. Cần Thơ', '0947800418', 'ttrang@gmail.com', '', 1),
('NCC20', 'b', 'b', 'b', 'b', 'f', 1),
('NCC21', 'huyhuy', 'h', 'h', 'h', 'f', 1),
('NCC3', 'Công ty Lan Chi', 'Lê Hồng Phong, Trà Nóc, Cần Thơ', '0947800418', 'lchi@gmail.com', '', 1),
('NCC4', 'Công ty Nhật Công', 'Ninh Kiều, Cần Thơ', '0126547896', 'ncong@gmail.com', '', 1),
('NCC7', 'Công ty Kim Chi', 'Trà Nóc, Cần Thơ', '0976780618', 'kimchi@gmail.com', '', 1),
('NCC9', 'Thủy Trân', 'nhà tui chứ đâu', '0939614616', 'tp@gmail.com', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MaNV` varchar(20) NOT NULL,
  `TenNV` varchar(50) NOT NULL,
  `CMND` varchar(20) NOT NULL,
  `GioiTinh` tinyint(1) NOT NULL,
  `NgaySinh` date NOT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `DiaChi` text NOT NULL,
  `MatKhau` varchar(20) NOT NULL,
  `MaCV` varchar(20) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MaNV`, `TenNV`, `CMND`, `GioiTinh`, `NgaySinh`, `SoDienThoai`, `DiaChi`, `MatKhau`, `MaCV`, `TrangThai`) VALUES
('admin', 'Thủy Trân', '362441457', 0, '1996-07-30', '0939614616', 'Cần Thơ', '123', '', 1),
('NV1', 'Huyền Trân', '360579632', 0, '1996-06-08', '0163257963', 'Sóc Trăng', '123', '', 0),
('NV2', 'huy', '36214587', 0, '2017-12-27', '01222444666', 'Vĩnh Long', '123456', '', 1),
('NV3', 'Thanh Dương', '123456789', 1, '1996-08-17', '01256874632', 'Hậu Giang', '123456', '', 1),
('NV4', 'Yến Phi', '654772143', 0, '1999-12-27', '091874563', 'Tiền Giang', '123456', '', 1),
('NV5', 'Quế Phương', '362145987', 0, '1996-11-30', '0125632784', 'Cần Thơ', '123456', '', 1),
('NV6', 'Tèo', '', 1, '0000-00-00', '', '', '123456', '', 0),
('NV7', 'tèo', '', 1, '0000-00-00', '', '', '123456', '', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieumuahang`
--

CREATE TABLE `phieumuahang` (
  `MaPhieu` varchar(20) NOT NULL,
  `NgayBD` date NOT NULL,
  `NgayKT` date NOT NULL,
  `GiaTri` double NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phieumuahang`
--

INSERT INTO `phieumuahang` (`MaPhieu`, `NgayBD`, `NgayKT`, `GiaTri`, `TrangThai`) VALUES
('PMH1', '2017-12-30', '2017-12-30', 50000, 1),
('PMH2', '2017-12-30', '2017-12-30', 20000, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

CREATE TABLE `phieunhap` (
  `MaPhieu` varchar(20) NOT NULL,
  `NgayNhap` datetime NOT NULL,
  `MaCTSP` varchar(50) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `GiaNhap` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`MaPhieu`, `NgayNhap`, `MaCTSP`, `SoLuong`, `GiaNhap`) VALUES
('PN1', '2017-12-22 10:05:02', 'CST_TinhDau_Milaganis_ct', 50, 126000),
('PN12', '2017-12-23 17:48:39', '5', 5, 121000),
('PN13', '2017-12-23 17:48:39', '6', 5, 121000),
('PN14', '2017-12-23 17:48:39', '7', 5, 121000),
('PN15', '2017-12-23 17:54:40', '8', 20, 52000),
('PN2', '2017-12-22 10:06:12', 'Son_Maybe_BaMau_PK01', 20, 103500),
('PN3', '2017-12-22 10:06:12', 'Son_Maybe_BaMau_RD01', 10, 103500),
('PN4', '2017-12-22 10:08:03', 'SRM_Senka_ct', 10, 35200);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pmh_gh`
--

CREATE TABLE `pmh_gh` (
  `MaPhieu` varchar(20) NOT NULL,
  `MaGH` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `pmh_gh`
--

INSERT INTO `pmh_gh` (`MaPhieu`, `MaGH`) VALUES
('PMH1', 'GH7'),
('PMH2', 'GH7');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pmh_hd`
--

CREATE TABLE `pmh_hd` (
  `MaPhieu` varchar(20) NOT NULL,
  `MaHD` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` varchar(50) NOT NULL,
  `TenSP` varchar(200) NOT NULL,
  `DonViTinh` varchar(20) NOT NULL,
  `TrongLuong` varchar(20) NOT NULL,
  `ThuongHieu` varchar(50) NOT NULL,
  `NgaySX` date NOT NULL,
  `HanSuDung` date NOT NULL,
  `QuyCachDongGoi` varchar(100) NOT NULL,
  `GiaDeXuat` double NOT NULL,
  `MoTa` text NOT NULL,
  `Thue` int(11) NOT NULL,
  `GiaBan` double NOT NULL,
  `MaNCC` varchar(20) NOT NULL,
  `MaDM` varchar(20) NOT NULL,
  `MaKM` varchar(20) NOT NULL,
  `GiaNhap` double NOT NULL,
  `NgayNhap` datetime NOT NULL,
  `LuotMua` int(11) NOT NULL,
  `TrangThai` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `DonViTinh`, `TrongLuong`, `ThuongHieu`, `NgaySX`, `HanSuDung`, `QuyCachDongGoi`, `GiaDeXuat`, `MoTa`, `Thue`, `GiaBan`, `MaNCC`, `MaDM`, `MaKM`, `GiaNhap`, `NgayNhap`, `LuotMua`, `TrangThai`) VALUES
('', '', '', '', '', '0000-00-00', '0000-00-00', '', 0, '', 0, 0, '', '', '', 0, '0000-00-00 00:00:00', 2, 0),
('CST_TinhDau_Milaganis', 'Tinh Dầu Bưởi Milaganics (30ml)', 'Chai', '30ml', 'Milaganis', '2016-08-04', '2021-08-04', 'Chai', 250000, 'd', 10, 135000, 'NCC1', 'DT', '000', 98000, '2017-12-04 00:00:00', 3, 1),
('KeMay_MasterBrown', 'Chì Kẻ Mày Maybelline Master Brow ', 'Cây', '0.23g', 'Maybelline', '0000-00-00', '0000-00-00', 'Hộp', 0, 'Chì Kẻ Mày Maybelline Master Brow (0.23g) ', 5, 0, 'NCC3', 'KMAY', '', 0, '2017-12-23 17:54:40', 13, 1),
('SON_KEM_Riche', 'Son Kem L\'Oreal Color Riche Extraordinaire 5.5ml ', 'Thỏi', '5.5 ml', 'L\'OREAL', '0000-00-00', '0000-00-00', 'Hộp', 0, '', 5, 0, 'NCC4', 'SKem', '', 0, '2017-12-23 16:53:11', 0, 1),
('SON_Maybe_BaMau', 'Son Ba Màu Maybelline Bitten 3.9g ', 'Thỏi', '3.9g', 'Maybelline', '2017-07-30', '2020-07-30', 'Thỏi', 140000, 'Hiệu ứng loang màu nước tạo nên màu sắc sống động cho đôi môi đẹp tự nhiên<br/>\r\nCông thức Ultra Creamy cho đôi môi căng mọng, dưỡng ẩm môi suốt 12h liền<br/>\r\n3 Shades màu OMBRE từ đậm sang nhạt trong 1 cây son tạo hiệu ứng ombre môi chỉ với 1 lần tô son<br/>', 10, 140000, 'NCC2', 'SThoi', '000', 85000, '2017-12-06 21:41:14', 15, 1),
('SRM_Senka', 'Sữa Rửa Mặt Tẩy Trang 2 Tác Dụng Senka Perfect Double Wash 120g - 60124 ', 'Tuýp', '120g', 'Senka', '2017-12-07', '2020-12-07', 'Dạng tuýp', 79000, '100% từ các nguyên liệu tại Nhật Bản<br/>\r\nChiết xuất tơ tằm trắng<br/>\r\nLàm sạch bụi bẩn và bả nhờn<br/>\r\nKhông chứa chất độc hại<br/>', 10, 79000, 'NCC3', 'SRM', '000', 51500, '2017-12-06 00:00:00', 16, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`MaBL`);

--
-- Chỉ mục cho bảng `chitietgiohang`
--
ALTER TABLE `chitietgiohang`
  ADD PRIMARY KEY (`MaGH`,`MaCTSP`);

--
-- Chỉ mục cho bảng `chitiethoadon`
--
ALTER TABLE `chitiethoadon`
  ADD PRIMARY KEY (`MaHD`,`MaCTSP`);

--
-- Chỉ mục cho bảng `chitietluong`
--
ALTER TABLE `chitietluong`
  ADD PRIMARY KEY (`MaNV`,`Ngay`);

--
-- Chỉ mục cho bảng `chitietsanpham`
--
ALTER TABLE `chitietsanpham`
  ADD PRIMARY KEY (`MaCTSP`);

--
-- Chỉ mục cho bảng `chucvu`
--
ALTER TABLE `chucvu`
  ADD PRIMARY KEY (`MaCV`);

--
-- Chỉ mục cho bảng `ctsp_km`
--
ALTER TABLE `ctsp_km`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`MaDM`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`MaGH`);

--
-- Chỉ mục cho bảng `hinhanh`
--
ALTER TABLE `hinhanh`
  ADD PRIMARY KEY (`MaHA`);

--
-- Chỉ mục cho bảng `hoadon`
--
ALTER TABLE `hoadon`
  ADD PRIMARY KEY (`MaHD`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`);

--
-- Chỉ mục cho bảng `khuyenmai`
--
ALTER TABLE `khuyenmai`
  ADD PRIMARY KEY (`MaKM`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MaNCC`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MaNV`);

--
-- Chỉ mục cho bảng `phieumuahang`
--
ALTER TABLE `phieumuahang`
  ADD PRIMARY KEY (`MaPhieu`);

--
-- Chỉ mục cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD PRIMARY KEY (`MaPhieu`);

--
-- Chỉ mục cho bảng `pmh_gh`
--
ALTER TABLE `pmh_gh`
  ADD PRIMARY KEY (`MaPhieu`,`MaGH`);

--
-- Chỉ mục cho bảng `pmh_hd`
--
ALTER TABLE `pmh_hd`
  ADD PRIMARY KEY (`MaPhieu`,`MaHD`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
