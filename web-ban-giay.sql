-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 14, 2025 lúc 08:26 AM
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
-- Cơ sở dữ liệu: `web-ban-giay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `total_money` decimal(10,0) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT 'COD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `email`, `address`, `note`, `total_money`, `status`, `created_at`, `payment_method`) VALUES
(1, 0, 'Bùi Ngọc Kim Ngân', '0842042184', NULL, '360/10/33 Phạm Hữu Lầu , Phước Kiển , Nhà Bè', NULL, 600000, 2, '2025-12-01 14:00:57', 'COD'),
(2, 0, 'Bùi Ngọc Kim Ngân', '0842042184', '', '360/10/33 Phạm Hữu Lầu , Phước Kiển , Nhà Bè', NULL, 600000, 2, '2025-12-01 15:09:40', 'BANK'),
(3, 0, 'Bùi Ngọc Kim Ngân', '0842042184', '', '360/10/33 Phạm Hữu Lầu , Phước Kiển , Nhà Bè', NULL, 600000, 2, '2025-12-01 15:10:58', 'BANK'),
(5, 0, 'Kim Ngân', '0842042184', '', '360/10/33 Phạm Hữu Lầu , Phước Kiển , Nhà Bè', NULL, 1800900, 2, '2025-12-01 18:03:57', 'BANK'),
(6, 0, 'ngân', '12345678', '', '12345678', NULL, 3200000, 2, '2025-12-13 15:46:31', 'COD'),
(7, 0, 'Ái Thảo', '0842042184', '', '360/10/33 Phạm Hữu Lầu , Phước Kiển , Nhà Bè', NULL, 499000, 2, '2025-12-13 15:48:01', 'COD');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 3, NULL, 600000, 1),
(2, 2, 3, NULL, 600000, 1),
(3, 3, 3, NULL, 600000, 1),
(5, 5, 3, NULL, 600000, 3),
(6, 5, 1, NULL, 450, 2),
(7, 6, 20, NULL, 3200000, 1),
(8, 7, 17, NULL, 499000, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT 0,
  `category` varchar(50) DEFAULT 'Men'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `category_id`, `category`) VALUES
(1, 'giày A', 1000000, 'pu1.PNG', 'kkkkkk', 0, 'Men'),
(5, 'Giày Nike Court Shot Nam - Trắng Xanh Nâu', 2290000, 'nike_xanhngoc.PNG', 'Giày Nike Court Shot mang đến sự kết hợp hoàn hảo giữa thiết kế cổ điển và sự tiện dụng hàng ngày. Với vẻ ngoài tối giản, đôi giày này là lựa chọn lý tưởng cho những ai yêu thích phong cách giản đơn nhưng không kém phần sang trọng.\r\n\r\nĐặc điểm nổi bật:\r\nThân giày da cao cấp: Mang đến vẻ ngoài cổ điển, độ bền cao và dễ dàng vệ sinh, phù hợp cho mọi hoạt động hàng ngày.\r\nLớp lót thoáng khí: Lớp lưới bên trong giúp đôi giày luôn nhẹ nhàng và thoáng mát, tạo cảm giác dễ chịu suốt cả ngày dài.\r\nĐệm cổ và lưỡi gà êm ái: Phần cổ và lưỡi gà được gia cố đệm mềm, mang lại cảm giác thoải mái vượt trội khi di chuyển.\r\nChi tiết tinh tế: Logo Swoosh được thiết kế nổi bật với họa tiết khâu và bề mặt có kết cấu, tạo điểm nhấn đầy cuốn hút cho đôi giày.\r\nPhù hợp cho mọi hoàn cảnh\r\nNike Court Shot không chỉ mang đến sự thoải mái và bền bỉ mà còn là lựa chọn hoàn hảo để hoàn thiện phong cách tối giản của bạn, dù bạn đi dạo phố, đến văn phòng hay tham gia các hoạt động nhẹ nhàng hàng ngày.', 0, 'Men'),
(6, 'Giày Nike Court Shot Nam - Trắng Đen Nâu', 2290000, 'Nike1.PNG', 'Giày Nike Court Shot mang đến sự kết hợp hoàn hảo giữa thiết kế cổ điển và sự tiện dụng hàng ngày. Với vẻ ngoài tối giản, đôi giày này là lựa chọn lý tưởng cho những ai yêu thích phong cách giản đơn nhưng không kém phần sang trọng.\r\n\r\nĐặc điểm nổi bật:\r\nThân giày da cao cấp: Mang đến vẻ ngoài cổ điển, độ bền cao và dễ dàng vệ sinh, phù hợp cho mọi hoạt động hàng ngày.\r\nLớp lót thoáng khí: Lớp lưới bên trong giúp đôi giày luôn nhẹ nhàng và thoáng mát, tạo cảm giác dễ chịu suốt cả ngày dài.\r\nĐệm cổ và lưỡi gà êm ái: Phần cổ và lưỡi gà được gia cố đệm mềm, mang lại cảm giác thoải mái vượt trội khi di chuyển.\r\nChi tiết tinh tế: Logo Swoosh được thiết kế nổi bật với họa tiết khâu và bề mặt có kết cấu, tạo điểm nhấn đầy cuốn hút cho đôi giày.\r\nPhù hợp cho mọi hoàn cảnh\r\nNike Court Shot không chỉ mang đến sự thoải mái và bền bỉ mà còn là lựa chọn hoàn hảo để hoàn thiện phong cách tối giản của bạn, dù bạn đi dạo phố, đến văn phòng hay tham gia các hoạt động nhẹ nhàng hàng ngày.', 0, 'Men'),
(7, 'Giày Nike Pegasus 41 Nữ - Hồng Nâu', 3790000, 'Nike2.PNG', 'Giày Nike Pegasus 41: Đỉnh Cao Của Công Nghệ Và Hiệu Suất\r\nNike Pegasus 41 là siêu phẩm giày thể thao mới nhất nhà Nike trong năm nay. Với thiết kế tập trung vào sự thoải mái và hiệu suất cao, đôi giày này hứa hẹn mang đến cho bạn một trải nghiệm vượt trội.\r\n\r\nHãy cùng Myshoes.vn khám phá những điểm nổi bật của sản phẩm này và hiểu tại sao nó lại được ưa chuộng đến vậy.\r\n\r\nTính Năng Nổi Bật\r\nLưới Thoáng Khí Cao Cấp\r\n\r\nPhần upper của Nike Pegasus 41 được nâng cấp với chất liệu lưới kỹ thuật, giúp giảm trọng lượng tổng thể của giày và tăng cường khả năng thoáng khí. Điều này giúp đôi chân bạn luôn khô ráo và thoải mái, ngay cả khi chạy trong điều kiện thời tiết nóng bức.\r\nĐệm ReactX Foam Mới\r\n\r\nĐế giữa ReactX Foam của Nike Pegasus 41 là một cải tiến đáng kể, mang lại khả năng hoàn trả năng lượng vượt trội so với công nghệ React trước đây. Với độ phản hồi tốt hơn 13%, mỗi bước chạy của bạn sẽ trở nên nhẹ nhàng và mạnh mẽ hơn phiên bản tiền nhiệm Nike Pegasus 40.\r\nCông Nghệ Air Zoom\r\n\r\nGiày Nike Pegasus 41 được trang bị hai đơn vị Air Zoom ở phần mũi và gót chân, tạo ra sự đàn hồi và hỗ trợ tối ưu trong suốt quá trình chạy bộ. Kết hợp cùng đệm ReactX Foam, giày mang đến một chuyến chạy đầy năng lượng mà vẫn êm ái.\r\nĐế Ngoài Bền Bỉ Lấy Cảm Hứng Từ Waffle\r\n\r\nĐế ngoài với thiết kế lấy cảm hứng từ waffle không chỉ tăng cường độ bám mà còn tối ưu hóa tính linh hoạt. Bạn sẽ cảm nhận được sự tự tin khi chạy trên mọi địa hình với đôi giày này.\r\nThiết Kế Thân Thiện Với Môi Trường\r\n\r\nMột trong những điểm nhấn của Pegasus 41 là sự thân thiện với môi trường. Đệm ReactX Foam mới được sản xuất với quy trình giảm thiểu năng lượng, giúp giảm đến 43% lượng khí thải carbon so với công nghệ trước đây. Điều này không chỉ mang lại hiệu suất vượt trội mà còn giúp bảo vệ hành tinh của chúng ta.\r\nThông Số Kỹ Thuật\r\nTrọng Lượng: Khoảng 297g (size 42.5 nam)\r\nĐộ Chênh Giữa Gót Và Mũi Giày: 10mm\r\nForm Giày: MR-10 – form chuẩn, nhất quán (giống với Pegasus 40)\r\nVới những cải tiến vượt trội về công nghệ và thiết kế, Nike Pegasus 41 không chỉ là một đôi giày chạy bộ thông thường, mà còn là một biểu tượng của sự bền bỉ, hiệu suất và trách nhiệm với môi trường. Đây chính là sự lựa chọn lý tưởng cho những ai muốn nâng tầm trải nghiệm chạy bộ của mình. Hãy qua Myshoes.vn thử ngay và cảm nhận sự khác biệt mà đôi giày này mang lại.', 0, 'Women'),
(8, 'Giày Nike Run Swift 3 Nữ - Trắng Xám', 2190000, 'Nike3.PNG', 'Giày Nike Run Swift 3 là mẫu giày được thiết kế cực kỳ đẹp và tinh tế với đặc điểm rất thoáng khí, êm và rất nhẹ. Đây là mẫu giày có thể sử dụng trong mọi hoạt động hàng ngày.\r\n\r\nVới phần upper làm bằng chất liệu vải mesh mềm mại và thoáng giúp vận động thoải mái. Phần đế giữa bằng vật liệu siêu nhẹ khiến cho Nike Run Swift 3 là mẫu giày rất được yêu thích.', 0, 'Women'),
(9, 'Giày Adidas Ultraboost 5X Nữ - Trắng Đen', 4190000, 'Das1.PNG', 'Giày Adidas Ultraboost 5X là thế hệ BOOST mới giúp bạn dễ dàng chinh phục những cột mốc chạy bộ mới. Sử dụng phiên bản BOOST nhẹ nhất của adidas, đôi giày mang đến khả năng hoàn trả năng lượng liên tục, giúp cơ thể luôn tràn đầy sức bền từ lúc bắt đầu cho đến khi cán đích.\r\n\r\nHệ thống Torsion System nằm giữa gót và mũi giày tăng cường độ ổn định, mang lại sải bước mượt mà, chắc chắn dù bạn chạy nhanh hay chạy dài. Bên dưới là đế Continental™ Rubber với độ bám cao trong cả điều kiện khô và ướt, giúp bạn tự tin trên mọi cung đường.\r\n\r\nBên cạnh hiệu năng vượt trội, sản phẩm còn sử dụng tối thiểu 20% chất liệu tái chế, góp phần giảm lãng phí và hướng đến phát triển bền vững.\r\n\r\nĐặc điểm nổi bật:\r\nBoost nhẹ nhất từ adidas, hoàn trả năng lượng liên tục.\r\n\r\nTorsion System tăng ổn định và định hướng chuyển động.\r\n\r\nĐế Continental™ bám đường vượt trội trong mọi điều kiện.\r\n\r\nMềm, êm và hỗ trợ tốt cho chạy nhanh lẫn chạy bền.\r\n\r\nChứa ít nhất 20% chất liệu tái chế, thân thiện môi trường.\r\n\r\nAdidas Ultraboost 5X – lựa chọn lý tưởng cho runner muốn đạt tốc độ, sự ổn định và cảm giác nhẹ nhàng tối đa trên mỗi bước chạy.', 0, 'Women'),
(10, 'Giày Adidas Advantage 2.0 Nam - Trắng Xanh', 1790000, 'Das2.PNG', 'Giày Adidas Advantage 2.0 là mẫu sneaker thời trang mang phong cách tối giản và hiện đại, dễ dàng kết hợp với mọi outfit hàng ngày. Thân giày da cao cấp cùng 3 sọc đục lỗ đặc trưng tạo điểm nhấn tinh tế, trong khi lót giày Cloudfoam Comfort mang lại cảm giác siêu êm, nhẹ và thoải mái trong từng bước di chuyển.\r\n\r\nĐế ngoài cao su bền chắc giúp tăng độ bám và ổn định, thích hợp cho sử dụng hằng ngày, đi làm hay dạo phố. Đặc biệt, sản phẩm được làm từ tối thiểu 20% chất liệu tái chế, góp phần giảm thiểu tác động đến môi trường mà vẫn giữ nguyên chất lượng và độ bền chuẩn Adidas.\r\n\r\nĐặc điểm nổi bật:\r\nThiết kế tối giản, thanh lịch, dễ phối đồ và phù hợp nhiều hoàn cảnh.\r\n\r\nThân giày chất liệu da cao cấp với 3 sọc đục lỗ tinh tế.\r\n\r\nLót Cloudfoam Comfort siêu êm, giảm chấn và tạo cảm giác nhẹ nhàng.\r\n\r\nĐế cao su chắc chắn, bám tốt và bền bỉ.\r\n\r\nSản xuất từ ít nhất 20% chất liệu tái chế, thân thiện với môi trường.\r\n\r\nAdidas Advantage 2.0 – đôi giày thời trang hoàn hảo cho cuộc sống năng động, mang lại sự thoải mái, tinh tế và bền vững trong từng bước đi.', 0, 'Men'),
(11, 'Giày adidas Galaxy 7 Nữ - Đen Trắng', 1790000, 'Das3.PNG', 'Adidas Galaxy 7 là đôi giày thể thao lý tưởng dành cho những ai muốn chinh phục từng bước chạy với sự thoải mái và hỗ trợ vượt trội. Mỗi cuộc chạy bộ không chỉ là một bài tập, mà còn là hành trình khám phá giới hạn của bản thân, và Galaxy 7 sẽ là người bạn đồng hành hoàn hảo trên hành trình đó.\r\n\r\nThiết kế và Chất liệu:\r\n\r\nGalaxy 7 được trang bị phần thân giày làm từ chất liệu dệt bền bỉ, mang lại sự hỗ trợ vững chắc và thoải mái từ những bước đầu tiên cho đến khi bạn hoàn thành chặng đường 5K. Thiết kế của giày không chỉ đảm bảo độ bền lâu dài mà còn giữ cho đôi chân bạn luôn thoải mái và được bảo vệ tốt nhất trong suốt quá trình chạy.\r\n\r\nCông nghệ và Hiệu năng:\r\n\r\nĐiểm nhấn của Adidas Galaxy 7 chính là đệm giữa Cloudfoam, giúp giảm chấn và mang lại cảm giác êm ái trên mỗi bước đi. Đệm này không chỉ giúp bạn duy trì sự thoải mái, mà còn hỗ trợ tốt trong việc nâng cao sức bền khi luyện tập. Cho dù bạn mới bắt đầu hay đã là một vận động viên giàu kinh nghiệm, Galaxy 7 sẽ giúp bạn đạt được mục tiêu với sự hỗ trợ toàn diện.\r\n\r\nPhong cách và Ứng dụng:\r\n\r\nVới thiết kế hiện đại và đầy phong cách, Adidas Galaxy 7 không chỉ phù hợp cho việc chạy bộ mà còn là lựa chọn lý tưởng cho các hoạt động thể thao và dạo phố hàng ngày. Đôi giày này mang đến sự linh hoạt, cho phép bạn dễ dàng chuyển từ sân tập đến các hoạt động thường nhật mà vẫn giữ được phong cách riêng.\r\n\r\nKết luận:\r\n\r\nAdidas Galaxy 7 là sự kết hợp hoàn hảo giữa công nghệ tiên tiến và thiết kế thời trang, mang đến cho bạn sự hỗ trợ và thoải mái tối đa trên từng bước chạy. Dù bạn đang khám phá khả năng của mình hay chinh phục những thử thách mới, Galaxy 7 sẽ luôn đồng hành và giúp bạn vượt qua mọi giới hạn.', 0, 'Women'),
(12, 'Giày Puma Caracal Nữ - Trắng Đen', 2000000, 'pu1.PNG', 'Giày Puma Caracal là mẫu sneaker lý tưởng cho phong cách casual hiện đại, mang đến sự thoải mái và linh hoạt cho mọi hoạt động hằng ngày. Thiết kế đơn giản nhưng sang trọng, dễ dàng chuyển đổi từ đi làm, đi học đến gặp gỡ bạn bè.\r\n\r\nThân giày làm từ chất liệu da cao cấp, kết hợp với lót giày SoftFoam+ mang lại cảm giác êm ái ngay từ bước chân đầu tiên. Công nghệ này giúp giảm áp lực, hỗ trợ di chuyển nhẹ nhàng và giữ cho bàn chân dễ chịu suốt cả ngày. Đế ngoài cao su bền chắc tăng độ bám, mang lại sự ổn định trong từng bước đi.\r\n\r\nĐặc điểm nổi bật:\r\nLót SoftFoam+ êm ái, tạo cảm giác thoải mái dài lâu.\r\n\r\nThân giày da cao cấp, bền đẹp và dễ vệ sinh.\r\n\r\nThiết kế trẻ trung, dễ phối, phù hợp nhiều hoàn cảnh.\r\n\r\nĐế cao su bám chắc, hạn chế trơn trượt.\r\n\r\nLogo PUMA Formstrip và Archive No.1 tăng tính nhận diện.\r\n\r\nPuma Caracal – đôi sneaker hoàn hảo cho phong cách sống năng động, mang lại độ bền, sự thoải mái và tính thời trang trong từng bước di chuyển.', 0, 'Women'),
(13, 'Giày Puma Caven 2.0 Nam Nữ - Trắng Xanh', 2000000, 'pu2.PNG', 'Giày Puma Caven 2.0 mang đến sự kết hợp hoàn hảo giữa phong cách cổ điển và công nghệ hiện đại. Được chế tác từ da cao cấp cùng các chi tiết tinh xảo, đôi giày không chỉ nổi bật về tính thẩm mỹ mà còn hướng đến sự bền vững và thân thiện với môi trường. Đây là lựa chọn lý tưởng cho những ai yêu thích sneaker thời trang, thoải mái và có trách nhiệm với hành tinh.\r\n\r\nƯu điểm nổi bật:\r\nChất liệu da cao cấp: Tạo cảm giác sang trọng, bền bỉ theo thời gian.\r\n\r\nCông nghệ SoftFoam: Lót giày êm ái, hỗ trợ đi lại cả ngày mà không gây mỏi.\r\n\r\nMũi giày đục lỗ: Tăng khả năng thoáng khí, giữ cho bàn chân luôn khô thoáng.\r\n\r\nThân thiện môi trường: Sử dụng ít nhất 20% vật liệu tái chế ở phần upper và 10% tái chế ở phần đế.\r\n\r\nPhong cách linh hoạt: Phù hợp cả khi đi dạo phố, đi làm hay thư giãn cuối tuần.\r\n\r\nMua ngay Giày Puma Caven 2.0 chính hãng tại Myshoes.vn để sở hữu đôi giày bền đẹp, thoải mái và mang đậm phong cách cổ điển hiện đại, đồng thời chung tay vì một tương lai bền vững.', 0, 'Women'),
(14, 'Giày Puma Court Breaker Derby Nam - Trắng', 1590000, 'pu3.PNG', 'Giày Puma Court Breaker Derby sở hữu thiết kế kinh điển với phần upper da cao cấp kết hợp cùng đế cao su dày dặn, mang đến vẻ ngoài sang trọng và sự bền bỉ vượt thời gian. Đây là mẫu sneaker lý tưởng cho những ai yêu thích phong cách tối giản nhưng vẫn đậm chất thể thao.\r\n\r\nĐặc điểm nổi bật:\r\nUpper da cao cấp, mềm mại và chắc chắn.\r\n\r\nĐế cao su dày tăng độ bám và độ bền khi di chuyển.\r\n\r\nKiểu dáng cổ điển, dễ phối với nhiều trang phục.\r\n\r\nBiểu tượng thương hiệu PUMA tinh tế, khẳng định phong cách.\r\n\r\nThêm ngay Puma Court Breaker Derby vào bộ sưu tập sneaker của bạn tại Myshoes.vn để trải nghiệm sự kết hợp hoàn hảo giữa thời trang và tiện dụng.', 0, 'Men'),
(15, 'Giày Puma Caven Mix Nam Nữ - Trắng Xám1690', 1690000, 'pu4.PNG', 'Giày Puma Caven Mix là sự kết hợp hoàn hảo giữa nét hoài cổ và phong cách thời thượng. Với đường nét tinh tế, kiểu dáng cool ngầu, cùng các chi tiết hiện đại, đôi giày này dễ dàng phù hợp với mọi trang phục và hoàn cảnh.\r\n\r\nĐặc điểm nổi bật:\r\nThiết kế cổ điển: Đường nét sạch sẽ, vẻ ngoài thanh lịch và mạnh mẽ.\r\nThân giày cao cấp: Bề mặt trơn láng kết hợp với các lỗ đục tinh tế giúp tăng tính thẩm mỹ và độ thoáng khí.\r\nĐế giày xếp lớp: Được thiết kế với các chi tiết vân nổi tạo sự độc đáo và bám đường tốt.\r\nLót giày SOFTFOAM+: Tấm lót giày êm ái giúp tăng cường sự thoải mái với phần gót dày đặc biệt.\r\nVật liệu thân thiện: Thân giày được làm từ ít nhất 20% vật liệu tái chế, phần đế chứa ít nhất 10% chất liệu tái chế, thể hiện cam kết của Puma với môi trường.\r\nPuma Caven Mix là lựa chọn hoàn hảo cho những ai yêu thích sự cân bằng giữa cổ điển và hiện đại. Từ đường phố đến các sự kiện thường ngày, đôi giày này không chỉ mang lại sự thoải mái mà còn giúp bạn nổi bật với phong cách riêng.', 0, 'Men'),
(16, 'Giày Cao Gót Cao Gót Phối Dây Đá Trang Trí', 549000, 'Nu1.PNG', '', 0, 'Women'),
(17, 'Giày Cao Gót Sục Gót Trụ Thấp Phối Quai Ngang', 499000, 'Nu2.PNG', 'Kiểu dáng: Giày cao gót\r\nChất liệu: Si khác\r\nĐộ cao: 5cm\r\nMàu sắc: Hồng-Xám-Đen\r\nXuất xứ: Việt Nam', 0, 'Women'),
(18, 'Giày Sandal Phối Dây Đính Đá', 499000, 'Nu3.PNG', 'Kiểu dáng: Giày xăng đan\r\nChất liệu: Si mờ trơn\r\nĐộ cao: 3cm\r\nMàu sắc: Kem-Đen-Nâu\r\nXuất xứ: Việt Nam', 0, 'Women'),
(19, 'Dép Quai Dệt', 499000, 'Nu4.PNG', 'Kiểu dáng: Giày xăng đan\r\nChất liệu: Si mờ trơn\r\nĐộ cao: 3cm\r\nMàu sắc: Kem-Đen\r\nXuất xứ: Việt Nam', 0, 'Women'),
(20, 'Giày Thể Thao Nam Lacoste Men s Carnaby Pro 124 Shoes 7', 3200000, 'Lac1.PNG', 'Giày thể thao Lacoste Men s Carnaby Pro 124 Shoes  ấn tượng với vẻ ngoài được hoàn thiện từ chất liệu da cao cấp, mềm mịn. Phần đế giày được làm bằng cao su êm ái và ma sát tốt. Lót giày sử dụng thông thoáng, dày dặn, êm ái giúp chân luôn thoải mái dù mang giày suốt cả ngày.', 0, 'Men'),
(21, 'Giày tập thể thao nam SLIP-ON ANTA', 1390000, 'Giay1.PNG', 'Giày tập thể thao nam SLIP-ON ANTA 1124C7701-4\r\n\r\nĐôi giày tập với chất liệu thoáng khí, thiết kế ôm chân, mang đến trải nghiệm thoải mái tuyệt đối, nâng cao hiệu quả tập luyện.', 0, 'Men');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fullname`, `phone`, `role`) VALUES
(1, 'admin@gmail.com', '123456', 'Chủ Shop Đẹp Trai', NULL, 1),
(2, 'k.ngaan3014@gmail.com', '123456789', 'Bùi Ngọc Kim Ngân', NULL, 1),
(3, 'kimngan1804@gmail.com', '123456789', 'Kim Ngân', NULL, 0),
(7, 'ngocduyen@gmail.com', '123456', 'ngoc duyên', NULL, 1),
(8, 'dien@gmail.com', '123456', 'dien', NULL, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
