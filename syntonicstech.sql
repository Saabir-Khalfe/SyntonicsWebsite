SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `Admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



INSERT INTO `Admin` (`id`, `name`, `password`) VALUES
(1, 'admin', 'P@ssword');


CREATE TABLE `ClientCart` (
  `id` int(100) NOT NULL,
  `Client_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `Product_Name` varchar(100) NOT NULL,
  `Product_Price` int(10) NOT NULL,
  `Product_Quantity` int(10) NOT NULL,
  `Product_Image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `ClientFeedback` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `Client_Name` varchar(100) NOT NULL,
  `Email_Address` varchar(100) NOT NULL,
  `Phone_Number` varchar(12) NOT NULL,
  `Feedback` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `Orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `Client_Name` varchar(20) NOT NULL,
  `Phone_Number` varchar(10) NOT NULL,
  `Email_Address` varchar(50) NOT NULL,
  `Payment_Method` varchar(50) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Total_Products` varchar(1000) NOT NULL,
  `Total_Price` int(100) NOT NULL,
  `Order_Date` date NOT NULL DEFAULT current_timestamp(),
  `Payment_Status` varchar(20) NOT NULL DEFAULT 'Order Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `Inventory` (
  `id` int(100) NOT NULL,
  `Product_Name` varchar(100) NOT NULL,
  `Product_Description` varchar(500) NOT NULL,
  `Product_Price` int(10) NOT NULL,
  `Product_Image` varchar(100) NOT NULL,
  'category' varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `Clients` (
  `id` int(100) NOT NULL,
  `Clients_Name` varchar(20) NOT NULL,
  `Clients_EmailAddress` varchar(50) NOT NULL,
  `Clients_Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `ClientsWishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `Product_Name` varchar(100) NOT NULL,
  `Product_Price` int(100) NOT NULL,
  `Product_Image` varchar(100) NOT NULL,
  `Product_details` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `Admin`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ClientCart`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ClientFeedback`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `Inventory`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `Clients`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ClientsWishlist`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `Admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `ClientCart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;


ALTER TABLE `ClientFeedback`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;


ALTER TABLE `Orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;


ALTER TABLE `Inventory`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;


ALTER TABLE `Clients`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ClientsWishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;