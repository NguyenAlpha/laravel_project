SET NAMES utf8mb4;
USE laravel;

-- nhà cung cấp
CREATE TABLE IF NOT EXISTS `supplier`  (
  `supplier_id` INT PRIMARY KEY AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_phone` varchar(10) NOT NULL,
  `supplier_address` varchar(255) NOT NULL
) ENGINE=InnoDB;

-- người dùng
-- khi xóa user (user.status = 'đã xóa') thì các đơn hàng của user đó vẫn còn
-- email là duy nhất
CREATE TABLE IF NOT EXISTS `user`  (
  `user_id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) UNIQUE NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `sex` enum('nam','nữ') DEFAULT NULL,
  `phone_number` varchar(10) NOT NULL,
  `dob` date DEFAULT NULL,
  `status` enum('mở','khóa','đã xóa') NOT NULL DEFAULT 'mở',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `avatar_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB;

-- danh mục sản phẩm
CREATE TABLE IF NOT EXISTS `category`  (
  `category_id` varchar(255) PRIMARY KEY,
  `category_name` varchar(255) NOT NULL,
  `description` TEXT NULL
) ENGINE=InnoDB;

-- sản phẩm
CREATE TABLE IF NOT EXISTS `product`  (
  `product_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `stock` INT NOT NULL DEFAULT 0,
  `price` INT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('hiện','ẩn','đã xóa') NOT NULL DEFAULT 'hiện',
  `image_url` varchar(255) DEFAULT NULL,
  FOREIGN KEY (category_id) REFERENCES category(category_id)
) ENGINE=InnoDB;


-- phiếu nhập hàng
CREATE TABLE IF NOT EXISTS `receipt`  (
  `receipt_id` INT PRIMARY KEY AUTO_INCREMENT,
  `supplier_id` INT,
  `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('đang chờ','đã nhận','đã hủy') DEFAULT 'đang chờ',
  FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id)
) ENGINE=InnoDB;

-- địa chỉ người dùng
CREATE TABLE IF NOT EXISTS `address`  (
  `address_id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user(user_id)
) ENGINE=InnoDB;

-- Chi tiết phiếu nhập hàng
CREATE TABLE IF NOT EXISTS `receipt_detail`  (
  `receipt_detail_id` INT PRIMARY KEY AUTO_INCREMENT,
  `receipt_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` INT NOT NULL,
  FOREIGN KEY (receipt_id) REFERENCES receipt(receipt_id),
  FOREIGN KEY (product_id) REFERENCES product(product_id)
);

-- kho/tồn kho
CREATE TABLE IF NOT EXISTS `inventory`  (
  `inventory_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` INT,
  `quantity` INT NOT NULL,
  `type` ENUM('nhập hàng','xuất hàng','điều chỉnh') NOT NULL,
  `reference` VARCHAR(255),              -- mã đơn hàng hoặc phiếu nhập
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;

-- giỏ hàng
CREATE TABLE IF NOT EXISTS `cart`  (
  `cart_id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user(user_id)
) ENGINE=InnoDB;

-- chi tiết giỏ hàng
CREATE TABLE IF NOT EXISTS `cart_item`  (
  `item_id` INT PRIMARY KEY AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL CHECK (`quantity` > 0),
  FOREIGN KEY (cart_id) REFERENCES cart(cart_id),
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;




-- đơn hàng
CREATE TABLE IF NOT EXISTS `order`  (
  `order_id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivery_date` timestamp NULL,
  `total_amount` int NOT NULL,
  `status` enum('đã nhận hàng','chờ xác nhận','đang giao','đã xác nhận','đã hủy') NOT NULL DEFAULT 'chờ xác nhận',
  `payment_method` enum('chuyển khoản','tiền mặt') NOT NULL,
  `created_by` varchar(255) NULL,
  FOREIGN KEY (user_id) REFERENCES user(user_id)
) ENGINE=InnoDB;

-- chi tiết đơn hàng
CREATE TABLE IF NOT EXISTS `order_detail`  (
  `order_detail_id` int PRIMARY KEY AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  FOREIGN KEY (order_id) REFERENCES `order`(order_id),
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;





-- các bảng dưới này sẽ sửa lại sau
CREATE TABLE IF NOT EXISTS `screen_detail`  (
  `screen_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `kich_thuoc_man_hinh` varchar(255) NOT NULL,
  `tang_so_quet` varchar(255) NOT NULL,
  `ti_le` varchar(255) NOT NULL,
  `tam_nen` varchar(255) NOT NULL,
  `do_phan_giai` varchar(255) NOT NULL,
  `khoi_luong` varchar(255) NOT NULL,
  `description` TEXT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `laptop_gaming_detail`  (
  `laptop_gaming_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `gpu` varchar(255) NOT NULL,
  `cpu` varchar(255) NOT NULL,
  `ram` varchar(255) NOT NULL,
  `dung_luong` varchar(255) NOT NULL,
  `kich_thuoc_man_hinh` varchar(255) NOT NULL,
  `do_phan_giai` varchar(255) NOT NULL,
  `description` TEXT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `laptop_detail`  (
  `laptop_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `cpu` varchar(255) NOT NULL,
  `gpu` varchar(255) NOT NULL,
  `ram` varchar(255) NOT NULL,
  `dung_luong` varchar(255) NOT NULL,
  `kich_thuoc_man_hinh` varchar(255) NOT NULL,
  `do_phan_giai` varchar(255) NOT NULL,
  `description` TEXT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `gpu_detail`  (
  `gpu_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `gpu` varchar(255) NOT NULL,
  `cuda` varchar(255) NOT NULL,
  `bo_nho` varchar(255) NOT NULL,
  `nguon` varchar(255) NOT NULL,
  `description` TEXT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `headset_detail`  (
  `headset_id`INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `micro` enum('có','không') NOT NULL,
  `pin` varchar(255) NOT NULL,
  `ket_noi` varchar(255) NOT NULL,
  `description` TEXT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `mouse_detail`  (
  `mouse_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `ket_noi` varchar(255) NOT NULL,
  `description` TEXT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `keyboard_detail`  (
  `keyboard_id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `ket_noi` varchar(255) NOT NULL,
  `description` TEXT NULL,
  FOREIGN KEY (product_id) REFERENCES product(product_id)
) ENGINE=InnoDB;






INSERT INTO `category` (`category_id`, `category_name`, `description`) VALUES
('GPU',             'GPU',          NULL),
('Headset',       'Tai Nghe',       NULL),
('Keyboard',      'Bàn Phím',       NULL),
('Laptop',        'Laptop',         NULL),
('LaptopGaming',  'Laptop Gaming',  NULL),
('Screen',        'Màn Hình',       NULL),
('Mouse',         'Chuột',          NULL);

INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `stock`, `price`, `created_at`, `updated_at`, `status`, `image_url`) VALUES
(1, 'Màn hình MSI PRO MP242L',                                      'Screen',         35,     1890000,   '2025-01-21 11:22:13', '2025-01-21 11:22:13', 'hiện', '50725_m__n_h__nh_msi_pro_mp242l__4_.jpg'),
(2, 'Laptop ASUS VivoBook Go 14 E1404FA-NK177W',                    'Laptop',         19,     11490000,  '2025-02-04  14:32:39','2025-2-04  14:32:39', 'hiện', 'e1404fa-1.png'),
(3, 'Card màn hình MSI GeForce RTX 5090 32G GAMING TRIO OC',        'GPU',            68,     97990000,  '2025-02-05 09:45:29', '2025-02-05 09:45:29', 'hiện', 'bzilxs4m.png'),
(4, 'Laptop Gaming MSI Katana 15 B13UDXK 2270VN',                   'LaptopGaming',   25,     20900000,  '2025-05-23 04:43:37', '2025-05-23 04:43:37', 'hiện', '8qziagrd.png'),
(5, 'Laptop Lenovo LOQ 15ARP9 83JC003YVN',                          'LaptopGaming',   79,     27790000,  '2025-07-15 09:20:40', '2025-07-15 09:20:40', 'hiện', '48807_laptop_lenovo_loq_15arp9_83jc003yvn__3_.jpg'),
(6, 'Card màn hình ASUS Dual GeForce RTX™ 3060 V2 12GB GDDR6',      'GPU',            24,     7790000,   '2025-07-23 12:36:19', '2025-07-23 12:36:19', 'hiện', 'imagertx3060V2_12GB.png'),
(7, 'Laptop GIGABYTE G5 MF5-52VN383SH',                             'LaptopGaming',   34,     20790000,  '2025-07-23 13:37:34', '2025-07-23 13:37:34', 'hiện', '47728_laptop_gigabyte_g5_mf5_52vn383sh__1_.jpg'),
(8, 'Màn Hình Gaming GIGABYTE GS27F',                               'Screen',         86,     3298000,   '2025-07-26 16:32:14', '2025-07-26 16:32:14', 'hiện', 'man_hinh_gaming_gigabyte_gs27f__5_.jpg'),
(9, 'Laptop Acer Aspire Lite AL14-51M-36MH_NX.KTVSV.001',           'Laptop',         64,     9190000,   '2025-07-26 20:21:16', '2025-07-26 20:21:16', 'hiện', '49837_laptop_acer_aspire_lite_al14_51m_36mh_nx_ktvsv_001__2_.jpg'),
(10, 'Laptop Asus TUF Gaming F15 FX507ZC4-HN095W',                  'LaptopGaming',   49,     19990000,  '2025-09-23 12:42:05', '2025-09-23 12:42:05', 'hiện', '46655_laptop_asus_tuf_gaming_f15_fx507zc4_hn095w__3_.jpg'),
(11, 'Laptop Lenovo Legion Pro 5 16IRX9 83DF0046VN',                'LaptopGaming',   27,     51990000,  '2025-09-23 12:43:11', '2025-09-23 12:43:11', 'hiện', '47462_laptop_lenovo_legion_pro_5_16irx9_83df0046vn__1_.jpg'),
(12, 'Laptop Gaming Acer Aspire 7 A715-76G-5806 - NH.QMFSV.002',    'LaptopGaming',   50,     18990000,  '2025-09-23 12:45:36', '2025-09-23 12:45:36', 'hiện', '45836_ap7.jpg'),
(13, 'Laptop Gaming Acer Nitro 5 Tiger AN515-58-5935 NH.QLZSV.001', 'LaptopGaming',   80,     22290000,  '2025-09-23 12:46:57', '2025-09-23 12:46:57', 'hiện', '45837_bnfg.jpg'),
(14, 'Laptop Acer Aspire 3 A315-44P-R5QG NX.KSJSV.001',             'Laptop',         99,     12900000,  '2025-09-23 12:46:57', '2025-09-23 12:46:57', 'hiện', '50618_laptop_acer_aspire_3_a315_44p_r5qg_nx_ksjsv_001__4_.jpg'),
(15, 'Laptop Asus Vivobook 14 OLED A1405VA-KM095W',                 'Laptop',          0,     16990000,  '2025-09-23 13:24:38', '2025-09-23 13:24:38', 'hiện', '44758_laptop_asus_vivobook_14_oled_a1405va_km095w__7_.jpg'),
(16, 'Laptop HP VICTUS 15-fa1155TX 952R1PA_16G',                    'LaptopGaming',  100,     17990000,  '2025-09-23 13:27:44', '2025-09-23 13:27:44', 'ẩn',   '49855_laptop_hp_victus_15_fa1155tx_952r1pa_16g__2_.jpg');

INSERT INTO `laptop_detail` (`laptop_id`, `product_id`, `thuong_hieu`, `cpu`, `gpu`, `ram`, `dung_luong`, `kich_thuoc_man_hinh`, `do_phan_giai`, `description`) VALUES
(1, 2, 'Asus', 'AMD Ryzen 5 7520U', 'AMD Radeon Graphics', '16GB', '512GB', '14 inch', '1920x1080', NULL),
(2, 9, 'Acer', 'Intel Core i3-1215U', 'Intel UHD Graphics', '8GB', '256GB', '14 inch', '1920x1080', NULL),
(3, 14, 'Acer', 'AMD Ryzen 7 5700U', 'AMD Radeon Graphics', '16GB', '512GB', '15.6 inch', '1920x1080', NULL);







-- user id 1 password: password
-- INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `role`, `sex`, `phone_number`, `dob`, `status`, `created_at`, `updated_at`, `avatar_url`) VALUES
-- (1, 'nhat nguyen', '$2y$12$OB3IEwceg7PKw5P/dNyXtOWYfT.f9rUEYn8YXusghmUQ3H9KMKRIG', 'password@gmail.com', 'customer', 'nam', '0963944370', '2005-04-27', 'mở', '2025-09-27 12:34:21', '2025-09-27 19:34:43', NULL),
-- (2, 'admin', '$2y$12$CgkYyUuY5Z7aNDqkcvPFc.XpxUayCPwx1p3p9xrA/mZ3z5GVqoIn2', 'admin@gmail.com', 'admin', 'nam', '0123456789', NULL, 'mở', '2025-09-27 12:34:21', '2025-09-27 19:34:43', NULL);

DELIMITER //

CREATE TRIGGER trg_after_user_insert
AFTER INSERT ON `user`
FOR EACH ROW
BEGIN
  IF NEW.role = 'customer' THEN
    INSERT INTO cart (user_id)
    VALUES (NEW.user_id);
  END IF;
END;
//

DELIMITER ;



INSERT INTO `cart` (`cart_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-09-29 07:28:53', '2025-09-29 08:28:22');

INSERT INTO `cart_item` (`item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 5, 1);





INSERT INTO `address` (`address_id`, `user_id`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, '229 cao thăng, p13, q4, hcm', '2025-09-28 03:44:08', '2025-09-28 03:44:08'),
(2, 1, 'phường 13, quận 5, tphcm', '2025-09-28 04:12:28', '2025-09-28 04:12:40');





-- ---------------------------------------------------
INSERT INTO `order` (`order_id`, `user_id`, `address`, `order_date`, `delivery_date`, `total_amount`, `status`, `payment_method`) VALUES
(1, 1, 'phường 13, quận 5, tphcm', '2025-10-04 07:22:50', '2025-10-06 11:08:10', 12900000, 'đã nhận hàng', 'chuyển khoản'),
(2, 1, 'phường 13, quận 5, tphcm', '2025-10-04 09:32:07', NULL, 1890000, 'chờ xác nhận', 'tiền mặt'),
(3, 1, 'phường 13, quận 5, tphcm', '2025-10-04 14:33:26', NULL, 23770000, 'đã hủy', 'tiền mặt'),
(4, 1, 'phường 13, quận 5, tphcm', '2025-10-04 14:57:34', NULL, 9190000, 'đã xác nhận', 'chuyển khoản'),
(5, 1, 'phường 13, quận 5, tphcm', '2025-10-04 15:04:24', NULL, 9190000, 'đang giao', 'chuyển khoản');

DELIMITER //

CREATE TRIGGER after_order_insert
AFTER INSERT ON `order`
FOR EACH ROW
BEGIN
  -- Chỉ chạy nếu created_by KHÁC 'admin'
  IF NEW.created_by <> 'admin' THEN
  
    -- Chèn dữ liệu từ cart_item vào order_detail
    INSERT INTO order_detail (order_id, product_id, quantity, price)
    SELECT 
      NEW.order_id, 
      ci.product_id, 
      ci.quantity, 
      p.price
    FROM cart_item ci
    INNER JOIN cart c ON ci.cart_id = c.cart_id
    INNER JOIN product p ON ci.product_id = p.product_id
    WHERE c.user_id = NEW.user_id;
    
    -- Xóa các mục trong cart_item sau khi đã chuyển sang order_detail
    DELETE ci FROM cart_item ci
    INNER JOIN cart c ON ci.cart_id = c.cart_id
    WHERE c.user_id = NEW.user_id;
  
  END IF;
END;
//

DELIMITER ;


-- ---------
DELIMITER //

CREATE TRIGGER after_order_update
AFTER UPDATE ON `order`
FOR EACH ROW
BEGIN
  -- Chỉ xử lý khi status thay đổi từ `chờ xác nhận` thành 'đã xác nhận'
  IF NEW.status = 'đã xác nhận' AND OLD.status != 'đã xác nhận' AND OLD.status = 'chờ xác nhận' THEN
    -- Chèn dữ liệu từ order_detail vào inventory với type là 'xuất hàng'
    INSERT INTO inventory (product_id, quantity, type, reference)
    SELECT 
      od.product_id,
      od.quantity * -1,
      'xuất hàng',
      CONCAT('order ', NEW.order_id)
    FROM order_detail od
    WHERE od.order_id = NEW.order_id;
  END IF;
END;
//

DELIMITER ;

-- ---------
DELIMITER $$

CREATE TRIGGER after_order_cancelled
AFTER UPDATE ON `order`
FOR EACH ROW
BEGIN
  -- Chỉ xử lý khi status thay đổi thành 'đã hủy' và trạng thái trước đó là 'đã xác nhận' hoặc 'đang giao'
  IF NEW.status = 'đã hủy' AND OLD.status != 'đã hủy' AND OLD.status IN ('đã xác nhận', 'đang giao') THEN
    -- Chèn dữ liệu từ order_detail vào inventory với type là 'điều chỉnh'
    -- Số lượng dương để bù lại hàng đã xuất trước đó
    INSERT INTO inventory (product_id, quantity, type, reference)
    SELECT 
      od.product_id,
      od.quantity,  -- Số lượng dương để thêm lại vào kho
      'điều chỉnh',
      CONCAT('order ', NEW.order_id, ' - hủy đơn')
    FROM order_detail od
    WHERE od.order_id = NEW.order_id;
  END IF;
END$$

DELIMITER ;


-- ---------
DELIMITER //

CREATE TRIGGER before_order_received
BEFORE UPDATE ON `order`
FOR EACH ROW
BEGIN
    -- Chỉ xử lý khi status thay đổi thành 'đã nhận hàng'
    IF NEW.status = 'đã nhận hàng' AND OLD.status != 'đã nhận hàng' THEN
        -- Cập nhật delivery_date thành thời gian hiện tại
        SET NEW.delivery_date = CURRENT_TIMESTAMP;
    END IF;
END;
//

DELIMITER ;


-- ---------------------------------------------------
INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 14, 1, 12900000),
(2, 2, 1, 1, 1890000),
(3, 3, 1, 2, 1890000),
(4, 3, 10, 1, 19990000),
(5, 4, 9, 1, 9190000),
(6, 5, 2, 1, 11490000);







-- ---------------------------------------------------
INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_phone`, `supplier_address`) VALUES
(1, 'Công Ty TNHH Nhập Khẩu Điện Tử', '0933224455', 'Số 654, Quận 1, TPHCM'),
(2, 'Công Ty TNHH Hòa Đông', '0267876543', 'Số 23, Đường Điện Biên Phủ, Tỉnh Bình Dương'),
(3, 'Công Ty TNHH Nhập Khẩu Mỹ', '0786767677', 'Số 356, Xa Lộ Hà Nội, TP Thủ Đức, TPHCM');




INSERT INTO `receipt` (`receipt_id`, `supplier_id`, `order_date`, `status`) VALUES
(1, 1, '2025-09-28 13:18:31', 'đã nhận'),
(2, 3, '2025-09-28 14:22:56', 'đang chờ'),
(3, 1, '2025-09-28 17:54:26', 'đã nhận');

DELIMITER $$
CREATE TRIGGER `trg_after_receipt_update` AFTER UPDATE ON `receipt` FOR EACH ROW BEGIN
  -- Chỉ xử lý khi status đổi từ 'đang chờ' sang 'đã nhận'
  IF OLD.status = 'đang chờ' AND NEW.status = 'đã nhận' THEN
    INSERT INTO inventory (product_id, quantity, `type`, reference, created_at)
    SELECT 
      rd.product_id,
      rd.quantity,
      'nhập hàng',
      CONCAT('PN', NEW.receipt_id),  -- reference có thể là mã phiếu nhập
      NOW()
    FROM receipt_detail rd
    WHERE rd.receipt_id = NEW.receipt_id;
  END IF;
END
$$
DELIMITER ;






INSERT INTO `receipt_detail` (`receipt_detail_id`, `receipt_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 35, 1530000),
(2, 1, 2, 20, 9490000),
(3, 1, 3, 68, 95900000),
(4, 1, 4, 25, 18840000),
(5, 1, 5, 79, 25500000),
(6, 1, 6, 24, 18380000),
(7, 1, 7, 34, 17580000),
(8, 1, 8, 86, 2990000),
(9, 1, 9, 65, 8900000),
(10, 1, 10, 39, 16820000),
(11, 1, 11, 17, 45330000),
(12, 1, 12, 50, 17100000),
(13, 1, 13, 80, 20000000),
(14, 1, 14, 100, 11800000),
(15, 1, 16, 100, 16800000),
(16, 2, 5, 40, 25350000),
(17, 2, 6, 60, 18400000),
(18, 2, 7, 45, 17550000),
(19, 3, 10, 10, 15750000),
(20, 3, 11, 10, 45000000);





INSERT INTO `inventory` (`inventory_id`, `product_id`, `quantity`, `type`, `reference`, `created_at`) VALUES
(1, 1, 35, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(2, 2, 20, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(3, 3, 68, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(4, 4, 25, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(5, 5, 79, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(6, 6, 24, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(7, 7, 34, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(8, 8, 86, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(9, 9, 65, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(10, 10, 39, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(11, 11, 17, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(12, 12, 50, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(13, 13, 80, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(14, 14, 100, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(15, 16, 100, 'nhập hàng', 'PN1', '2025-09-28 13:21:23'),
(16, 10, 10, 'nhập hàng', 'PN3', '2025-09-28 20:03:18'),
(17, 11, 10, 'nhập hàng', 'PN3', '2025-09-28 20:03:18'),
(18, 14, -1, 'xuất hàng', 'order 1', '2025-10-04 12:07:55'),
(19, 9, -1, 'xuất hàng', 'order 4', '2025-10-04 16:33:46'),
(20, 2, -1, 'xuất hàng', 'order 5', '2025-10-04 16:35:23');

DELIMITER $$
CREATE TRIGGER `trg_after_inventory_insert` AFTER INSERT ON `inventory` FOR EACH ROW BEGIN
  IF NEW.type = 'nhập hàng' THEN
    UPDATE product
    SET stock = stock + NEW.quantity
    WHERE product_id = NEW.product_id;
  ELSEIF NEW.type = 'xuất hàng' THEN
    UPDATE product
    SET stock = stock + NEW.quantity
    WHERE product_id = NEW.product_id;
  ELSEIF NEW.type = 'điều chỉnh' THEN
    UPDATE product
    SET stock = stock + NEW.quantity
    WHERE product_id = NEW.product_id;
  END IF;
END
$$
DELIMITER ;







CREATE TABLE IF NOT EXISTS `sessions`  (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CREATE TABLE IF NOT EXISTS `migrations`  (
--   `id` int(10) UNSIGNED NOT NULL,
--   `migration` varchar(255) NOT NULL,
--   `batch` int(11) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
-- (1, '2025_09_19_013440_create_address_table', 0),
-- (2, '2025_09_19_013440_create_cart_table', 0),
-- (3, '2025_09_19_013440_create_cart_item_table', 0),
-- (4, '2025_09_19_013440_create_category_table', 0),
-- (5, '2025_09_19_013440_create_gpu_detail_table', 0),
-- (6, '2025_09_19_013440_create_headset_detail_table', 0),
-- (7, '2025_09_19_013440_create_inventory_table', 0),
-- (8, '2025_09_19_013440_create_keyboard_detail_table', 0),
-- (9, '2025_09_19_013440_create_laptop_detail_table', 0),
-- (10, '2025_09_19_013440_create_laptop_gaming_detail_table', 0),
-- (11, '2025_09_19_013440_create_mouse_detail_table', 0),
-- (12, '2025_09_19_013440_create_order_table', 0),
-- (13, '2025_09_19_013440_create_order_detail_table', 0),
-- (14, '2025_09_19_013440_create_product_table', 0),
-- (15, '2025_09_19_013440_create_receipt_table', 0),
-- (16, '2025_09_19_013440_create_receipt_detail_table', 0),
-- (17, '2025_09_19_013440_create_screen_detail_table', 0),
-- (18, '2025_09_19_013440_create_supplier_table', 0),
-- (19, '2025_09_19_013440_create_user_table', 0),
-- (20, '2025_09_19_013443_add_foreign_keys_to_address_table', 0),
-- (21, '2025_09_19_013443_add_foreign_keys_to_cart_table', 0),
-- (22, '2025_09_19_013443_add_foreign_keys_to_cart_item_table', 0),
-- (23, '2025_09_19_013443_add_foreign_keys_to_gpu_detail_table', 0),
-- (24, '2025_09_19_013443_add_foreign_keys_to_headset_detail_table', 0),
-- (25, '2025_09_19_013443_add_foreign_keys_to_inventory_table', 0),
-- (26, '2025_09_19_013443_add_foreign_keys_to_keyboard_detail_table', 0),
-- (27, '2025_09_19_013443_add_foreign_keys_to_laptop_detail_table', 0),
-- (28, '2025_09_19_013443_add_foreign_keys_to_laptop_gaming_detail_table', 0),
-- (29, '2025_09_19_013443_add_foreign_keys_to_mouse_detail_table', 0),
-- (30, '2025_09_19_013443_add_foreign_keys_to_order_table', 0),
-- (31, '2025_09_19_013443_add_foreign_keys_to_order_detail_table', 0),
-- (32, '2025_09_19_013443_add_foreign_keys_to_receipt_table', 0),
-- (33, '2025_09_19_013443_add_foreign_keys_to_receipt_detail_table', 0),
-- (34, '2025_09_19_013443_add_foreign_keys_to_screen_detail_table', 0),
-- (35, '2025_09_19_013443_add_foreign_keys_to_product_table', 0),
-- (36, '2025_09_19_080126_create_sessions_table', 0);