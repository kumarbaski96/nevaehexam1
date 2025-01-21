-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 04:31 AM
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
  `sec_code` varchar(10) NOT NULL,
  `exam_duration` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `is_exam_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`, `mobile`, `email`, `password`, `exam_type`, `designation`, `total_marks`, `sec_code`, `exam_duration`, `status`, `is_exam_completed`) VALUES
(9, 'Baski Kumar Saw', '7488162756', 'baski12.kumar@gmail.com', '$2y$10$ky2GiDxS6vFvb9StyK00S.CEXnjXwxii0cXGm024Smi0934mUXLU.', 'Python', 'Software engineer', 2, '59EFBN', '3600', 'Completed', 1),
(14, 'Deepak', '6393424013', 'deepak.kedia@nevaehtech.com', '$2y$10$EKbQNf0b5jkFpem00Q.2EO4OeE4IVkLmGtSyyZzDcL7g6///nPYzC', 'Analytical', 'President', 7, '8EGTZ7', '', 'Completed', 1),
(15, 'Manoj', '8765432345', 'manoj@gmail.com', '$2y$10$C3qMfYeT185qakruEBrLH.H5g8UxymCRAJL0GAY8MvQgJXPpuG8Mm', 'Analytical', 'Data Analysis', 3, '8EGTZ7', '', 'Completed', 1);

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
(5, 'C++', 0);

-- --------------------------------------------------------

--
-- Table structure for table `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `header`
--

INSERT INTO `header` (`id`, `name`, `url`, `parent_id`, `sort_order`) VALUES
(1, 'Create Question', 'question_bank.php', NULL, 1),
(2, 'Show Questions', 'show_question.php', NULL, 2),
(3, 'Add Questions', 'add_question.php', NULL, 3),
(4, 'Show Exam Type', 'show_exam_type.php', NULL, 4),
(5, 'All Questions', 'all_questions.php', 2, 1),
(6, 'Pending Questions', 'pending_questions.php', 2, 2),
(7, 'Active Exams', 'active_exams.php', 4, 1),
(8, 'Archived Exams', 'archived_exams.php', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mcq_questions`
--

CREATE TABLE `mcq_questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(255) NOT NULL,
  `option2` varchar(255) NOT NULL,
  `option3` varchar(255) NOT NULL,
  `option4` varchar(255) NOT NULL,
  `correct_option` enum('1','2','3','4') NOT NULL,
  `level` enum('1','2','3','4','5') NOT NULL,
  `exam_type` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(27, 'Python', '7.What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2, 1, 1),
(29, 'Python', 'Which keyword is used to define a variable in Python?', 'a) var', 'b) def', 'c) int', 'd) No keyword is required', 4, 2, 1),
(31, 'Python', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'a) True', 'b) False', 'c) 5', '4) Error', 1, 3, 1);

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
(1, 'Analytical', '8EGTZ7', '4. In a linear regression model, what does the coefficient of an independent variable represent?', 'A) The average value of the dependent variable', 'B) The change in the dependent variable for a one-unit change in the independent variable', 'C) The total sum of squares of the dependent variable', 'D) The intercept of the regression line', 2),
(2, 'Analytical', '8EGTZ7', '7. Which machine learning algorithm is best suited for predicting stock prices?', 'A) K-means clustering', 'B) Linear regression', 'C) Decision trees', 'D) Apriori algorithm', 2),
(3, 'Analytical', '8EGTZ7', '16. How do you handle missing values in a DataFrame?', 'A) df.dropna()', 'B) df.fillna()', 'C) df.replace_na()', 'D) Both A and B', 4),
(4, 'Analytical', '8EGTZ7', '11. In financial forecasting, which method involves using historical data to predict future financial performance?', 'A) Monte Carlo Simulation', 'B) Time Series Analysis', 'C) SWOT Analysis', 'D) PEST Analysis', 2),
(5, 'Analytical', '8EGTZ7', '2. In Python, which library is commonly used for data manipulation and analysis?', 'A) NumPy', 'B) Matplotlib', 'C) Pandas', 'D) Scikit-learn', 3),
(6, 'Analytical', '8EGTZ7', '14. In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3),
(7, 'Analytical', '8EGTZ7', '3. Which of these describes the Debt-to-Equity Ratio?', 'A) A measure of a company\'s profitability', 'B) A ratio comparing the company\'s total liabilities to its shareholder equity', 'C) A ratio assessing the efficiency of a company\'s operations', 'D) A measure of the company\'s market value', 2),
(8, 'Analytical', '8EGTZ7', '6. What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2),
(9, 'Analytical', '8EGTZ7', '9. Which type of neural network is best suited for sequential data, such as financial time series?', 'A) Convolutional Neural Network (CNN)', 'B) Recurrent Neural Network (RNN)', 'C) Feedforward Neural Network', 'D) Generative Adversarial Network (GAN)', 2),
(10, 'Python', '5E618I', '4. What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2),
(11, 'Python', '5E618I', '7.What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2),
(12, 'Python', '5E618I', '1.	Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(13, 'Python', '5E618I', '5. How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(14, 'Python', '5E618I', '2. Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3),
(15, 'Python', '5E618I', '3. What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(16, 'Python', '5E618I', '6. Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1),
(17, 'Python', '4QP7LK', '4. What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2),
(18, 'Python', '4QP7LK', '1.	Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(19, 'Python', '4QP7LK', '2. Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3),
(20, 'Python', '4QP7LK', '5. How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(21, 'Python', '4QP7LK', '3. What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(22, 'Python', '4QP7LK', '6. Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1),
(23, 'Python', 'IOSE3N', '1.	Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(24, 'Python', 'IOSE3N', '7.What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2),
(25, 'Python', 'IOSE3N', '5. How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(26, 'Python', 'IOSE3N', '2. Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3),
(27, 'Python', 'IOSE3N', '6. Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1),
(28, 'Python', 'IOSE3N', '3. What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(29, 'Python', '59EFBN', '7.What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2),
(30, 'Python', '59EFBN', '2. Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3),
(31, 'Python', '59EFBN', '6. Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1);

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
(52, 9, 'Python', 29, '7.What does the len() function do?', 2, 2, 'Correct', '2025-01-21 02:24:35'),
(53, 9, 'Python', 30, '2. Which of the following is used to define a block of code in Python?', 2, 3, 'Incorrect', '2025-01-21 02:24:35'),
(54, 9, 'Python', 31, '6. Which of the following will create a list in Python?', 1, 1, 'Correct', '2025-01-21 02:24:35');

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
(14, 9, 'Python', 2);

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
-- Indexes for table `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `exam_type_menu`
--
ALTER TABLE `exam_type_menu`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `question_results`
--
ALTER TABLE `question_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `header`
--
ALTER TABLE `header`
  ADD CONSTRAINT `header_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `header` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
