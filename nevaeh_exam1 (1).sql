-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 11:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nevaeh_exam1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `password`) VALUES
(1, 'admin@example.com', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `exam_type` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `total_marks` int(4) NOT NULL,
  `sec_code` int(10) NOT NULL,
  `q_level` int(3) NOT NULL,
  `status` varchar(50) NOT NULL,
  `is_exam_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`, `mobile`, `email`, `password`, `exam_type`, `designation`, `total_marks`, `sec_code`, `q_level`, `status`, `is_exam_completed`) VALUES
(9, 'Baski Kumar Saw', '7488162756', 'baski12.kumar@gmail.com', '$2y$10$ky2GiDxS6vFvb9StyK00S.CEXnjXwxii0cXGm024Smi0934mUXLU.', 'Python', 'Software engineer', 3, 1234, 1, 'Completed', 1),
(14, 'Deepak', '6393424013', 'deepak.kedia@nevaehtech.com', '$2y$10$EKbQNf0b5jkFpem00Q.2EO4OeE4IVkLmGtSyyZzDcL7g6///nPYzC', 'Analytical', 'President', 7, 2343, 2, 'Completed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_type_menu`
--

CREATE TABLE `exam_type_menu` (
  `id` int(5) NOT NULL,
  `exam_type` varchar(100) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_type_menu`
--

INSERT INTO `exam_type_menu` (`id`, `exam_type`, `status`) VALUES
(1, 'Analytical', 1),
(3, 'Python', 1),
(5, 'C++', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam_type` text DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option1` varchar(255) DEFAULT NULL,
  `option2` varchar(255) DEFAULT NULL,
  `option3` varchar(255) DEFAULT NULL,
  `option4` varchar(255) DEFAULT NULL,
  `correct_option` int(11) DEFAULT NULL,
  `level` int(2) NOT NULL,
  `status` int(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `exam_type`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_option`, `level`, `status`) VALUES
(1, 'Analytical', '1. Which financial ratio measures a company\'s ability to meet its short-term obligations?', 'A) Return on Equity (ROE)', 'B) Current Ratio', 'C) Debt-to-Equity Ratio', 'D) Gross Profit Margin', 2, 1, 1),
(2, 'Analytical', '2. In Python, which library is commonly used for data manipulation and analysis?', 'A) NumPy', 'B) Matplotlib', 'C) Pandas', 'D) Scikit-learn', 3, 2, 1),
(3, 'Analytical', '3. Which of these describes the Debt-to-Equity Ratio?', 'A) A measure of a company\'s profitability', 'B) A ratio comparing the company\'s total liabilities to its shareholder equity', 'C) A ratio assessing the efficiency of a company\'s operations', 'D) A measure of the company\'s market value', 2, 3, 1),
(4, 'Analytical', '4. In a linear regression model, what does the coefficient of an independent variable represent?', 'A) The average value of the dependent variable', 'B) The change in the dependent variable for a one-unit change in the independent variable', 'C) The total sum of squares of the dependent variable', 'D) The intercept of the regression line', 2, 1, 1),
(5, 'Analytical', '5. What is the purpose of the R-squared value in regression analysis?', 'A) To measure the strength and direction of the linear relationship between two variables', 'B) To determine the significance of regression coefficients', 'C) To quantify the proportion of variation in the dependent variable explained by the independent variables', 'D) To test for the presence of multicollinearity', 3, 2, 1),
(6, 'Analytical', '6. What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2, 3, 1),
(7, 'Analytical', '7. Which machine learning algorithm is best suited for predicting stock prices?', 'A) K-means clustering', 'B) Linear regression', 'C) Decision trees', 'D) Apriori algorithm', 2, 1, 1),
(8, 'Analytical', '8. What does \"over fitting\" mean in the context of machine learning?', 'A) The model performs poorly on training data but well on test data', 'B) The model performs well on training data but poorly on test data', 'C) The model uses too few features', 'D) The model is unable to make any predictions', 2, 2, 1),
(9, 'Analytical', '9. Which type of neural network is best suited for sequential data, such as financial time series?', 'A) Convolutional Neural Network (CNN)', 'B) Recurrent Neural Network (RNN)', 'C) Feedforward Neural Network', 'D) Generative Adversarial Network (GAN)', 2, 3, 1),
(10, 'Analytical', '10. What is the purpose of the train-test split in machine learning?', 'A) To increase the size of the training data', 'B) To ensure the model is not overfitting', 'C) To optimize the model\\\'s hyperparameters', 'D) To validate the model on unseen data', 4, 1, 1),
(11, 'Analytical', '11. In financial forecasting, which method involves using historical data to predict future financial performance?', 'A) Monte Carlo Simulation', 'B) Time Series Analysis', 'C) SWOT Analysis', 'D) PEST Analysis', 2, 2, 1),
(12, 'Analytical', '12. What does the term \"Big Data\" refer to in the context of financial analysis?', 'A) Large volumes of structured and unstructured data that can be analyzed for insights', 'B) Small, manageable sets of data used for daily operations', 'C) Data stored in traditional databases', 'D) Data primarily used for marketing purposes', 1, 3, 1),
(13, 'Analytical', '13. In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3, 1, 1),
(14, 'Analytical', '14. In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3, 2, 1),
(15, 'Analytical', '15. Which function is used to compute descriptive statistics of a DataFrame in Pandas?', 'A) df.stats()', 'B) df.summary()', 'C) df.describe()', 'D) df.detail()', 3, 3, 1),
(16, 'Analytical', '16. How do you handle missing values in a DataFrame?', 'A) df.dropna()', 'B) df.fillna()', 'C) df.replace_na()', 'D) Both A and B', 4, 1, 1),
(17, 'Analytical', '17. What SQL statement is used to retrieve data from a database?', 'A) GET', 'B) SELECT', 'C) RETRIEVE', 'D) EXTRACT', 2, 2, 1),
(18, 'Analytical', '18. What does the mean() function compute in statistics?', 'A) The median of a dataset', 'B) The mode of a dataset', 'C) The average value of a dataset', 'D) The range of a dataset', 3, 3, 1),
(19, 'Analytical', '19. In the context of data science, what does the term \"feature\" refer to?', 'A) The target variable to be predicted', 'B) The output of the model', 'C) An individual measurable property or characteristic of a phenomenon being observed', 'D) The algorithm used for modeling', 3, 1, 1),
(20, 'Analytical', '20. Which type of data visualization is used to show the distribution of a dataset?', 'A) Line chart', 'B) Scatter plot', 'C) Histogram', 'D) Pie chart', 3, 2, 1),
(21, 'Python', '1.	Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2, 1, 1),
(22, 'Python', '2. Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3, 2, 1),
(23, 'Python', '3. What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2, 3, 1),
(24, 'Python', '4. What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2, 1, 1),
(25, 'Python', '5. How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3, 2, 1),
(26, 'Python', '6. Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1, 3, 1),
(27, 'Python', '7.What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE `question_bank` (
  `id` int(11) NOT NULL,
  `exam_type` varchar(50) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `option1` text DEFAULT NULL,
  `option2` text DEFAULT NULL,
  `option3` text DEFAULT NULL,
  `option4` text DEFAULT NULL,
  `correct_option` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_bank`
--

INSERT INTO `question_bank` (`id`, `exam_type`, `code`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_option`) VALUES
(1, 'Analytical', 'G8THMN', '19. In the context of data science, what does the term \"feature\" refer to?', 'A) The target variable to be predicted', 'B) The output of the model', 'C) An individual measurable property or characteristic of a phenomenon being observed', 'D) The algorithm used for modeling', 3),
(2, 'Analytical', 'G8THMN', '13. In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3),
(3, 'Analytical', 'G8THMN', '11. In financial forecasting, which method involves using historical data to predict future financial performance?', 'A) Monte Carlo Simulation', 'B) Time Series Analysis', 'C) SWOT Analysis', 'D) PEST Analysis', 2),
(4, 'Analytical', 'G8THMN', '17. What SQL statement is used to retrieve data from a database?', 'A) GET', 'B) SELECT', 'C) RETRIEVE', 'D) EXTRACT', 2),
(5, 'Analytical', 'G8THMN', '3. Which of these describes the Debt-to-Equity Ratio?', 'A) A measure of a company\'s profitability', 'B) A ratio comparing the company\'s total liabilities to its shareholder equity', 'C) A ratio assessing the efficiency of a company\'s operations', 'D) A measure of the company\'s market value', 2),
(6, 'Analytical', 'G8THMN', '15. Which function is used to compute descriptive statistics of a DataFrame in Pandas?', 'A) df.stats()', 'B) df.summary()', 'C) df.describe()', 'D) df.detail()', 3),
(7, 'Analytical', '1RSAT8', '16. How do you handle missing values in a DataFrame?', 'A) df.dropna()', 'B) df.fillna()', 'C) df.replace_na()', 'D) Both A and B', 4),
(8, 'Analytical', '1RSAT8', '4. In a linear regression model, what does the coefficient of an independent variable represent?', 'A) The average value of the dependent variable', 'B) The change in the dependent variable for a one-unit change in the independent variable', 'C) The total sum of squares of the dependent variable', 'D) The intercept of the regression line', 2),
(9, 'Analytical', '1RSAT8', '14. In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3),
(10, 'Analytical', '1RSAT8', '17. What SQL statement is used to retrieve data from a database?', 'A) GET', 'B) SELECT', 'C) RETRIEVE', 'D) EXTRACT', 2),
(11, 'Analytical', '1RSAT8', '6. What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2),
(12, 'Analytical', '1RSAT8', '18. What does the mean() function compute in statistics?', 'A) The median of a dataset', 'B) The mode of a dataset', 'C) The average value of a dataset', 'D) The range of a dataset', 3),
(13, 'Analytical', '9EHLTA', '16. How do you handle missing values in a DataFrame?', 'A) df.dropna()', 'B) df.fillna()', 'C) df.replace_na()', 'D) Both A and B', 4),
(14, 'Analytical', '9EHLTA', '10. What is the purpose of the train-test split in machine learning?', 'A) To increase the size of the training data', 'B) To ensure the model is not overfitting', 'C) To optimize the model\\\'s hyperparameters', 'D) To validate the model on unseen data', 4),
(15, 'Analytical', '9EHLTA', '5. What is the purpose of the R-squared value in regression analysis?', 'A) To measure the strength and direction of the linear relationship between two variables', 'B) To determine the significance of regression coefficients', 'C) To quantify the proportion of variation in the dependent variable explained by the independent variables', 'D) To test for the presence of multicollinearity', 3),
(16, 'Analytical', '9EHLTA', '2. In Python, which library is commonly used for data manipulation and analysis?', 'A) NumPy', 'B) Matplotlib', 'C) Pandas', 'D) Scikit-learn', 3),
(17, 'Analytical', '9EHLTA', '6. What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2),
(18, 'Analytical', '9EHLTA', '9. Which type of neural network is best suited for sequential data, such as financial time series?', 'A) Convolutional Neural Network (CNN)', 'B) Recurrent Neural Network (RNN)', 'C) Feedforward Neural Network', 'D) Generative Adversarial Network (GAN)', 2);

-- --------------------------------------------------------

--
-- Table structure for table `question_results`
--

CREATE TABLE `question_results` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `exam_type` varchar(255) NOT NULL,
  `question_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `user_answer` int(11) NOT NULL,
  `correct_option` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_results`
--

INSERT INTO `question_results` (`id`, `candidate_id`, `exam_type`, `question_id`, `question`, `user_answer`, `correct_option`, `status`, `created_at`) VALUES
(90, 9, 'Python', 21, '1.	Which of the following is the correct extension of Python files?', 2, 2, 'Correct', '2025-01-15 07:37:37'),
(91, 9, 'Python', 22, '2. Which of the following is used to define a block of code in Python?', 2, 3, 'Incorrect', '2025-01-15 07:37:37'),
(92, 9, 'Python', 23, '3. What will be the output of the following code?<br>print(type(2))', 2, 2, 'Correct', '2025-01-15 07:37:37'),
(93, 9, 'Python', 24, '4. What is the correct syntax to create a function in Python?', 2, 2, 'Correct', '2025-01-15 07:37:37'),
(94, 9, 'Python', 25, '5. How do you insert a comment in Python code?', 2, 3, 'Incorrect', '2025-01-15 07:37:37'),
(95, 9, 'Python', 26, '6. Which of the following will create a list in Python?', 2, 1, 'Incorrect', '2025-01-15 07:37:37'),
(96, 14, 'Analytical', 1, '1. Which financial ratio measures a company\'s ability to meet its short-term obligations?', 2, 2, 'Correct', '2025-01-16 07:56:43'),
(97, 14, 'Analytical', 2, '2. In Python, which library is commonly used for data manipulation and analysis?', 1, 3, 'Incorrect', '2025-01-16 07:56:43'),
(98, 14, 'Analytical', 3, '3. Which of these describes the Debt-to-Equity Ratio?', 4, 2, 'Incorrect', '2025-01-16 07:56:43'),
(99, 14, 'Analytical', 4, '4. In a linear regression model, what does the coefficient of an independent variable represent?', 3, 2, 'Incorrect', '2025-01-16 07:56:43'),
(100, 14, 'Analytical', 5, '5. What is the purpose of the R-squared value in regression analysis?', 3, 3, 'Correct', '2025-01-16 07:56:43'),
(101, 14, 'Analytical', 6, '6. What is the primary purpose of a confusion matrix in evaluating a classification model?', 2, 2, 'Correct', '2025-01-16 07:56:43'),
(102, 14, 'Analytical', 7, '7. Which machine learning algorithm is best suited for predicting stock prices?', 3, 2, 'Incorrect', '2025-01-16 07:56:43'),
(103, 14, 'Analytical', 8, '8. What does \"over fitting\" mean in the context of machine learning?', 2, 2, 'Correct', '2025-01-16 07:56:43'),
(104, 14, 'Analytical', 9, '9. Which type of neural network is best suited for sequential data, such as financial time series?', 2, 2, 'Correct', '2025-01-16 07:56:43'),
(105, 14, 'Analytical', 10, '10. What is the purpose of the train-test split in machine learning?', 2, 4, 'Incorrect', '2025-01-16 07:56:43'),
(106, 14, 'Analytical', 11, '11. In financial forecasting, which method involves using historical data to predict future financial performance?', 2, 2, 'Correct', '2025-01-16 07:56:43'),
(107, 14, 'Analytical', 12, '12. What does the term \"Big Data\" refer to in the context of financial analysis?', 2, 1, 'Incorrect', '2025-01-16 07:56:43'),
(108, 14, 'Analytical', 13, '13. In logistic regression, what type of dependent variable is used?', 1, 3, 'Incorrect', '2025-01-16 07:56:43'),
(109, 14, 'Analytical', 14, '14. In logistic regression, what type of dependent variable is used?', 4, 3, 'Incorrect', '2025-01-16 07:56:43'),
(110, 14, 'Analytical', 15, '15. Which function is used to compute descriptive statistics of a DataFrame in Pandas?', 1, 3, 'Incorrect', '2025-01-16 07:56:43'),
(111, 14, 'Analytical', 16, '16. How do you handle missing values in a DataFrame?', 3, 4, 'Incorrect', '2025-01-16 07:56:43'),
(112, 14, 'Analytical', 17, '17. What SQL statement is used to retrieve data from a database?', 2, 2, 'Correct', '2025-01-16 07:56:43'),
(113, 14, 'Analytical', 18, '18. What does the mean() function compute in statistics?', 1, 3, 'Incorrect', '2025-01-16 07:56:43'),
(114, 14, 'Analytical', 19, '19. In the context of data science, what does the term \"feature\" refer to?', 1, 3, 'Incorrect', '2025-01-16 07:56:43'),
(115, 14, 'Analytical', 20, '20. Which type of data visualization is used to show the distribution of a dataset?', 2, 3, 'Incorrect', '2025-01-16 07:56:43');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `exam_type` varchar(50) DEFAULT NULL,
  `marks_obtained` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `candidate_id`, `exam_type`, `marks_obtained`) VALUES
(2, 9, 'Python', 3),
(3, 14, 'Analytical', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_type_menu`
--
ALTER TABLE `exam_type_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_bank`
--
ALTER TABLE `question_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_results`
--
ALTER TABLE `question_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `exam_type_menu`
--
ALTER TABLE `exam_type_menu`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `question_results`
--
ALTER TABLE `question_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
