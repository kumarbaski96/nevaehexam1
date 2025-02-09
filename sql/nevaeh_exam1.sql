-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 04:49 PM
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
  `total_questions` int(3) NOT NULL,
  `total_marks` int(4) NOT NULL,
  `sec_code` varchar(10) NOT NULL,
  `exam_duration` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `is_exam_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`, `mobile`, `email`, `password`, `exam_type`, `designation`, `total_questions`, `total_marks`, `sec_code`, `exam_duration`, `status`, `is_exam_completed`) VALUES
(16, 'Baski Saw', '7488162756', 'baski12.kumar@gmail.com', '$2y$10$LRCnEWS/rcbayy2JJHTIJuEhrBVQ9OTYqYr.2UlapYyjN6kg/yxKi', 'Python', 'Software Developer', 16, 4, '2GPIY6', '1800', 'Completed', 1),
(17, 'Manoj Kumar', '9876567898', 'manoj@gmail.com', '$2y$10$Q3LiK4rGm7ORDJi6ob9myuAojt9ziSFwwOQy0BM21e.uUtZAl5RLq', 'Python', 'Software Developer', 0, 6, 'GDEMQT', '3600', 'Completed', 1),
(18, 'Krishna Kumar', '8977652356', 'krishna@gmail.com', '$2y$10$FnSRCQU.0sABcqmGwAYl4e5ocRp3TroQ7IBCMKNg/pYGidGR6L8eS', 'Python', 'Software Developer', 0, 5, 'LHB64U', '3600', 'Completed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_personal_details`
--

CREATE TABLE `candidate_personal_details` (
  `id` int(8) NOT NULL,
  `candidate_id` int(8) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate_personal_details`
--

INSERT INTO `candidate_personal_details` (`id`, `candidate_id`, `dob`, `gender`, `nationality`, `address`, `city`, `state`, `zip_code`, `created_at`) VALUES
(2, 16, '1992-09-07', 'Male', 'Indian', 'Dhaiya ,Dhanbad', 'Dhanbad', 'Jharkhand', '826004', '2025-02-01 04:32:23'),
(3, 16, '1992-09-07', 'Male', 'Indian', 'Meddle School Road,Dhaiya ,Dhanbad', 'Dhanbad', 'Jharkhand', '826004', '2025-02-01 04:34:34'),
(4, 18, '2025-02-04', 'Male', 'Indian', 'Dhaiya ,Dhanbad', 'Dhanbad', 'Jharkhand', '826004', '2025-02-06 11:17:34');

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
(5, 'C++', 1),
(6, 'Aptitude', 1),
(7, 'Java', 1),
(8, 'C', 1),
(9, 'PHP', 1);

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
(1, 'Home', 'index.php', NULL, 1),
(2, 'About', 'about.php', NULL, 2),
(3, 'Services', '#', NULL, 3),
(4, 'Web Development', 'web-dev.php', 3, 1),
(5, 'SEO Optimization', 'seo.php', 3, 2),
(6, 'Contact', 'contact.php', NULL, 4);

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
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `parent_id`, `link`, `sort_order`) VALUES
(1, 'Home', NULL, 'show_candidate.php', 1),
(2, 'Create Question', NULL, '#', 2),
(3, 'Single Question', 2, 'single_question_bank.php', 3),
(4, 'Multiple Question', 2, 'multiple_question_bank.php', 4),
(5, 'Show Questions', NULL, 'show_question.php', 5),
(6, 'Add Questions', NULL, '#', 6),
(7, 'Add Question', 6, 'add_question.php', 7),
(8, 'Add Bulk Question', 6, 'add_bulk_question.php', 8),
(9, 'Show Exam Type', NULL, 'show_exam_type.php', 9),
(10, 'Logout', NULL, 'index.php', 10);

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
(1, 'Analytical', 'Which financial ratio measures a company\'s ability to meet its short-term obligations?', 'Return on Equity (ROE)', 'Current Ratio', 'Debt-to-Equity Ratio', 'Gross Profit Margin', 2, 1, 1),
(2, 'Analytical', 'In Python, which library is commonly used for data manipulation and analysis?', 'NumPy', 'Matplotlib', 'Pandas', 'Scikit-learn', 3, 2, 1),
(3, 'Analytical', 'Which of these describes the Debt-to-Equity Ratio?', 'A measure of a company\'s profitability', 'A ratio comparing the company\'s total liabilities to its shareholder equity', 'A ratio assessing the efficiency of a company\'s operations', 'A measure of the company\'s market value', 2, 3, 1),
(4, 'Analytical', 'In a linear regression model, what does the coefficient of an independent variable represent?', 'The average value of the dependent variable', 'The change in the dependent variable for a one-unit change in the independent variable', 'The total sum of squares of the dependent variable', 'The intercept of the regression line', 2, 1, 1),
(5, 'Analytical', 'What is the purpose of the R-squared value in regression analysis?', 'To measure the strength and direction of the linear relationship between two variables', 'To determine the significance of regression coefficients', 'To quantify the proportion of variation in the dependent variable explained by the independent variables', 'To test for the presence of multicollinearity', 3, 2, 1),
(6, 'Analytical', 'What is the primary purpose of a confusion matrix in evaluating a classification model?', 'To summarize the performance of a regression model', 'To display the true positives, true negatives, false positives, and false negatives', 'To visualize the distribution of data', 'To calculate the mean absolute error', 2, 3, 1),
(7, 'Analytical', 'Which machine learning algorithm is best suited for predicting stock prices?', 'K-means clustering', 'Linear regression', 'Decision trees', 'Apriori algorithm', 2, 1, 1),
(8, 'Analytical', 'What does \"over fitting\" mean in the context of machine learning?', 'The model performs poorly on training data but well on test data', 'The model performs well on training data but poorly on test data', 'The model uses too few features', 'The model is unable to make any predictions', 2, 2, 1),
(9, 'Analytical', 'Which type of neural network is best suited for sequential data, such as financial time series?', 'Convolutional Neural Network (CNN)', 'Recurrent Neural Network (RNN)', 'Feedforward Neural Network', 'Generative Adversarial Network (GAN)', 2, 3, 1),
(10, 'Analytical', 'What is the purpose of the train-test split in machine learning?', 'To increase the size of the training data', 'To ensure the model is not overfitting', 'To optimize the model\\\'s hyperparameters', 'To validate the model on unseen data', 4, 1, 1),
(11, 'Analytical', 'In financial forecasting, which method involves using historical data to predict future financial performance?', 'Monte Carlo Simulation', 'Time Series Analysis', 'SWOT Analysis', 'PEST Analysis', 2, 2, 1),
(12, 'Analytical', 'What does the term \"Big Data\" refer to in the context of financial analysis?', 'Large volumes of structured and unstructured data that can be analyzed for insights', 'Small, manageable sets of data used for daily operations', 'Data stored in traditional databases', 'Data primarily used for marketing purposes', 1, 3, 1),
(13, 'Analytical', 'In logistic regression, what type of dependent variable is used?', 'Continuous', 'Ordinal', 'Binary', 'Nominal with more than two categories', 3, 1, 1),
(14, 'Analytical', 'In logistic regression, what type of dependent variable is used?', 'Continuous', 'Ordinal', 'Binary', 'Nominal with more than two categories', 3, 2, 1),
(15, 'Analytical', 'Which function is used to compute descriptive statistics of a DataFrame in Pandas?', 'df.stats()', 'df.summary()', 'df.describe()', 'df.detail()', 3, 3, 1),
(16, 'Analytical', 'How do you handle missing values in a DataFrame?', 'df.dropna()', 'df.fillna()', 'df.replace_na()', 'Both A and B', 4, 1, 1),
(17, 'Analytical', 'What SQL statement is used to retrieve data from a database?', 'GET', 'SELECT', 'RETRIEVE', 'EXTRACT', 2, 2, 1),
(18, 'Analytical', 'What does the mean() function compute in statistics?', 'The median of a dataset', 'The mode of a dataset', 'The average value of a dataset', 'The range of a dataset', 3, 3, 1),
(19, 'Analytical', 'In the context of data science, what does the term \"feature\" refer to?', 'The target variable to be predicted', 'The output of the model', 'An individual measurable property or characteristic of a phenomenon being observed', 'The algorithm used for modeling', 3, 1, 1),
(20, 'Analytical', 'Which type of data visualization is used to show the distribution of a dataset?', 'Line chart', 'Scatter plot', 'Histogram', 'Pie chart', 3, 2, 1),
(21, 'Python', 'Which of the following is the correct extension of Python files?', '.python', '.py', '.pyt', '.pyc', 2, 1, 1),
(22, 'Python', 'Which of the following is used to define a block of code in Python?', 'Curly braces {}', 'Parentheses ()', 'Indentation', 'Semi-colon ;', 3, 2, 1),
(23, 'Python', 'What will be the output of the following code?<br>print(type(2))', '<class \'float\'>', '<class \'int\'>', '<class \'bool\'>', '<class \'NoneType\'>', 2, 3, 1),
(24, 'Python', 'What is the correct syntax to create a function in Python?', 'function myFunction():', 'def myFunction():', 'create myFunction():', 'function: myFunction()', 2, 1, 1),
(25, 'Python', 'How do you insert a comment in Python code?', '// This is a comment', '/* This is a comment */', ' # This is a comment', '-- This is a comment', 3, 2, 1),
(26, 'Python', 'Which of the following will create a list in Python?', '[1, 2, 3]', '(1, 2, 3)', '{1, 2, 3}', '1, 2, 3', 1, 3, 1),
(27, 'Python', 'What does the len() function do?', 'Returns the length of a string', 'Returns the length of a list or string', 'Returns the size of the memory used by an object', 'Counts the number of spaces in a string', 2, 1, 1),
(29, 'Python', 'Which keyword is used to define a variable in Python?', 'var', 'def', 'int', 'No keyword is required', 4, 2, 1),
(31, 'Python', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'True', 'False', '5', 'Error', 1, 3, 1),
(32, 'Python', 'Which of the following is not a valid data type in Python?', 'int', 'float', 'real', 'str', 3, 1, 0),
(33, 'Python', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', '[2, 3]', '[3, 4]', '[1, 2, 3]', '[2, 3, 4]', 4, 2, 1),
(34, 'Python', 'How do you add an element to the end of a list in Python?', 'list.add()', 'list.append()', 'list.push()', 'list.insert()', 2, 3, 1),
(331, 'Python', 'Which of the following is a mutable data type in Python?', 'Tuple', 'String', 'List', 'Set', 3, 1, 1),
(332, 'Python', 'What keyword is used to define a function in Python?', 'func', 'define', 'def', 'lambda', 3, 2, 1),
(333, 'Python', 'What will be the output of print(type([]))?', 'List', '<class \'list\'>', 'Tuple', '<class \'tuple\'>', 2, 3, 1),
(334, 'Python', 'Which method is used to add an item to a list?', 'append()', 'add()', 'insert()', 'extend()', 1, 1, 1),
(335, 'Python', 'What will be the result of 10 // 3?', '3.33', '3', '4', 'Error', 2, 2, 1),
(336, 'Python', 'Which statement is used to exit a loop?', 'return', 'exit', 'break', 'stop', 3, 3, 1),
(337, 'Python', 'How do you start a comment in Python?', '//', '#', '--', '/*', 2, 1, 1),
(338, 'Python', 'What is the output of bool([])?', 'True', 'False', 'Error', 'None', 2, 2, 1),
(339, 'Python', 'Which module is used for regular expressions in Python?', 're', 'regex', 'pyre', 'regexp', 1, 3, 1),
(340, 'Python', 'What is the output of len(\'Python\')?', '5', '6', '7', 'Error', 2, 1, 1),
(341, 'Python', 'Which of these is used for reading input in Python?', 'cin', 'scanf', 'input()', 'read()', 3, 2, 1),
(342, 'Python', 'Which of the following is NOT a valid variable name in Python?', 'my_var', '2var', '_var', 'varName', 2, 3, 1),
(343, 'Python', 'What will be the output of \'Hello\' + \'World\'?', '\'Hello World\'', '\'HelloWorld\'', 'Hello+World', 'Error', 2, 1, 1),
(344, 'Python', 'What data type does the expression 5 / 2 return in Python 3?', 'int', 'float', 'double', 'Error', 2, 2, 1),
(345, 'Python', 'Which of the following is used to create an empty set?', '{}', 'set()', '[]', '()', 2, 3, 1),
(346, 'Python', 'What does the \'in\' keyword do?', 'Checks membership', 'Performs bitwise operation', 'Compares values', 'None of the above', 1, 1, 1),
(347, 'Python', 'How do you define a block of code in Python?', 'Using {}', 'Using indentation', 'Using brackets', 'Using \'begin\' and \'end\'', 2, 2, 1),
(348, 'Python', 'Which function is used to convert a string to an integer?', 'str()', 'int()', 'float()', 'toInt()', 2, 3, 1),
(349, 'Python', 'What is the default return type of input()?', 'int', 'string', 'float', 'bool', 2, 1, 1),
(350, 'Python', 'What does the \'is\' operator check?', 'Value equality', 'Identity equality', 'Both', 'None', 2, 2, 1),
(351, 'Python', 'Which module is used for handling dates and times in Python?', 'time', 'datetime', 'date', 'calendar', 2, 3, 1),
(352, 'Python', 'What is the output of print(3 * \'abc\')?', '\'abcabcabc\'', '\'abc*abc*abc\'', '\'abcabc\'', 'Error', 1, 1, 1),
(353, 'Python', 'Which method is used to remove an item from a dictionary?', 'remove()', 'del', 'discard()', 'pop()', 4, 2, 1),
(354, 'Python', 'What does range(5) return?', '1', '2', '3', '4', 5, 3, 1),
(355, 'Python', 'Which of the following is used to check if a key exists in a dictionary?', 'exists()', 'in', 'has_key()', 'find()', 2, 1, 1),
(356, 'Python', 'Which symbol is used for single-line comments in Python?', '#', '//', '--', '/*', 1, 2, 1),
(357, 'Python', 'Which data type is immutable?', 'List', 'Dictionary', 'Tuple', 'Set', 3, 3, 1),
(358, 'Python', 'What is the correct way to open a file for reading in Python?', 'open(\'file.txt\'', ' \'r\')', 'open(\'file.txt\'', ' \'w\')', 0, 1, 1),
(359, 'Python', 'What is the purpose of the \'finally\' block in exception handling?', 'To define the exception', 'To execute code regardless of exceptions', 'To catch all exceptions', 'None of the above', 2, 2, 1),
(360, 'Python', 'What does the \'pass\' keyword do?', 'Terminates the loop', 'Skips the current iteration', 'Does nothing', 'Raises an error', 3, 3, 1),
(361, 'Python', 'Which method converts all characters of a string to lowercase?', 'toLower()', 'lower()', 'tolowercase()', 'casefold()', 2, 1, 1),
(362, 'Python', 'Which of the following statements is correct about Python?', 'It is compiled only', 'It is interpreted only', 'It is both compiled and interpreted', 'None', 3, 2, 1),
(363, 'Python', 'How do you create a dictionary?', '{1', '2', '3}', '{key: value}', 0, 3, 1),
(364, 'Python', 'Which of the following is used to handle exceptions in Python?', 'try-except', 'catch-throw', 'handle()', 'error-catch', 1, 1, 1),
(365, 'Python', 'Which function is used to get the length of a list?', 'count()', 'size()', 'length()', 'len()', 4, 2, 1),
(366, 'Python', 'What is the purpose of the \'with\' statement?', 'To handle file operations', 'To define loops', 'To declare functions', 'To handle lists', 1, 3, 1),
(367, 'Python', 'Which keyword is used to create a class in Python?', 'class', 'Class', 'define', 'object', 1, 2, 1),
(368, 'Python', 'What is the output of print(3 == 3.0)?', 'True', 'False', 'Error', 'None', 1, 1, 1),
(369, 'Python', 'Which of the following creates a tuple?', '[]', '{}', '()', '<>', 3, 2, 1),
(370, 'Python', 'Which of the following is an assignment operator?', '==', '=', '===', '=>', 2, 3, 1),
(371, 'Python', 'What will be the result of bool(\'False\')?', 'True', 'False', 'Error', 'None', 1, 1, 1),
(372, 'Python', 'What will be the result of \'Hello\'.find(\'e\')?', '1', '2', '3', '-1', 2, 2, 1),
(373, 'Python', 'Which function is used to get a substring from a string?', 'substr()', 'slice()', 'substring()', 'split()', 2, 3, 1),
(374, 'Python', 'Which module is used to generate random numbers in Python?', 'random', 'rand', 'math', 'numbers', 1, 1, 1),
(375, 'Python', 'How do you create a set?', '{1', '2', '3}', '[1', 2, 2, 1),
(376, 'Python', 'Which function converts an integer to a string?', 'str()', 'string()', 'toString()', 'convert()', 1, 3, 1),
(377, 'Python', 'What is the result of type(10) in Python?', '<class \'int\'>', 'int', 'integer', '<type \'int\'>', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `question_bank`
--

CREATE TABLE `question_bank` (
  `id` int(11) NOT NULL,
  `question_id` int(9) NOT NULL,
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

INSERT INTO `question_bank` (`id`, `question_id`, `exam_type`, `code`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_option`) VALUES
(85, 16, 'Analytical', 'MUQX10', 'How do you handle missing values in a DataFrame?', 'A) df.dropna()', 'B) df.fillna()', 'C) df.replace_na()', 'D) Both A and B', 4),
(86, 14, 'Analytical', 'MUQX10', 'In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3),
(87, 3, 'Analytical', 'MUQX10', 'Which of these describes the Debt-to-Equity Ratio?', 'A) A measure of a company\'s profitability', 'B) A ratio comparing the company\'s total liabilities to its shareholder equity', 'C) A ratio assessing the efficiency of a company\'s operations', 'D) A measure of the company\'s market value', 2),
(88, 21, 'Aptitude', 'H2KB5R', 'Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(89, 29, 'Aptitude', 'H2KB5R', 'Which keyword is used to define a variable in Python?', 'a) var', 'b) def', 'c) int', 'd) No keyword is required', 4),
(90, 23, 'Aptitude', 'H2KB5R', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(91, 16, 'Aptitude', 'H2KB5R', 'How do you handle missing values in a DataFrame?', 'A) df.dropna()', 'B) df.fillna()', 'C) df.replace_na()', 'D) Both A and B', 4),
(92, 5, 'Aptitude', 'H2KB5R', 'What is the purpose of the R-squared value in regression analysis?', 'A) To measure the strength and direction of the linear relationship between two variables', 'B) To determine the significance of regression coefficients', 'C) To quantify the proportion of variation in the dependent variable explained by the independent variables', 'D) To test for the presence of multicollinearity', 3),
(93, 6, 'Aptitude', 'H2KB5R', 'What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2),
(94, 4, 'Aptitude', '1T6VA4', 'In a linear regression model, what does the coefficient of an independent variable represent?', 'A) The average value of the dependent variable', 'B) The change in the dependent variable for a one-unit change in the independent variable', 'C) The total sum of squares of the dependent variable', 'D) The intercept of the regression line', 2),
(95, 7, 'Aptitude', '1T6VA4', 'Which machine learning algorithm is best suited for predicting stock prices?', 'A) K-means clustering', 'B) Linear regression', 'C) Decision trees', 'D) Apriori algorithm', 2),
(96, 5, 'Aptitude', '1T6VA4', 'What is the purpose of the R-squared value in regression analysis?', 'A) To measure the strength and direction of the linear relationship between two variables', 'B) To determine the significance of regression coefficients', 'C) To quantify the proportion of variation in the dependent variable explained by the independent variables', 'D) To test for the presence of multicollinearity', 3),
(97, 20, 'Aptitude', '1T6VA4', 'Which type of data visualization is used to show the distribution of a dataset?', 'A) Line chart', 'B) Scatter plot', 'C) Histogram', 'D) Pie chart', 3),
(98, 12, 'Aptitude', '1T6VA4', 'What does the term \"Big Data\" refer to in the context of financial analysis?', 'A) Large volumes of structured and unstructured data that can be analyzed for insights', 'B) Small, manageable sets of data used for daily operations', 'C) Data stored in traditional databases', 'D) Data primarily used for marketing purposes', 1),
(99, 9, 'Aptitude', '1T6VA4', 'Which type of neural network is best suited for sequential data, such as financial time series?', 'A) Convolutional Neural Network (CNN)', 'B) Recurrent Neural Network (RNN)', 'C) Feedforward Neural Network', 'D) Generative Adversarial Network (GAN)', 2),
(100, 24, 'Aptitude', '1T6VA4', 'What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2),
(101, 21, 'Aptitude', '1T6VA4', 'Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(102, 25, 'Aptitude', '1T6VA4', 'How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(103, 29, 'Aptitude', '1T6VA4', 'Which keyword is used to define a variable in Python?', 'a) var', 'b) def', 'c) int', 'd) No keyword is required', 4),
(104, 26, 'Aptitude', '1T6VA4', 'Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1),
(105, 34, 'Aptitude', '1T6VA4', 'How do you add an element to the end of a list in Python?', 'a) list.add()', 'b) list.append()', 'c) list.push()', 'd) list.insert()', 2),
(106, 4, 'Aptitude', 'BW3KYR', 'In a linear regression model, what does the coefficient of an independent variable represent?', 'A) The average value of the dependent variable', 'B) The change in the dependent variable for a one-unit change in the independent variable', 'C) The total sum of squares of the dependent variable', 'D) The intercept of the regression line', 2),
(107, 19, 'Aptitude', 'BW3KYR', 'In the context of data science, what does the term \"feature\" refer to?', 'A) The target variable to be predicted', 'B) The output of the model', 'C) An individual measurable property or characteristic of a phenomenon being observed', 'D) The algorithm used for modeling', 3),
(108, 8, 'Aptitude', 'BW3KYR', 'What does \"over fitting\" mean in the context of machine learning?', 'A) The model performs poorly on training data but well on test data', 'B) The model performs well on training data but poorly on test data', 'C) The model uses too few features', 'D) The model is unable to make any predictions', 2),
(109, 5, 'Aptitude', 'BW3KYR', 'What is the purpose of the R-squared value in regression analysis?', 'A) To measure the strength and direction of the linear relationship between two variables', 'B) To determine the significance of regression coefficients', 'C) To quantify the proportion of variation in the dependent variable explained by the independent variables', 'D) To test for the presence of multicollinearity', 3),
(110, 6, 'Aptitude', 'BW3KYR', 'What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2),
(111, 9, 'Aptitude', 'BW3KYR', 'Which type of neural network is best suited for sequential data, such as financial time series?', 'A) Convolutional Neural Network (CNN)', 'B) Recurrent Neural Network (RNN)', 'C) Feedforward Neural Network', 'D) Generative Adversarial Network (GAN)', 2),
(112, 32, 'Aptitude', 'BW3KYR', 'Which of the following is not a valid data type in Python?', 'a)	int', 'b)	float', 'c)	real', 'd)	str', 3),
(113, 21, 'Aptitude', 'BW3KYR', 'Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(114, 22, 'Aptitude', 'BW3KYR', 'Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3),
(115, 25, 'Aptitude', 'BW3KYR', 'How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(116, 33, 'Aptitude', 'BW3KYR', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', 'a) [2, 3]', 'b) [3, 4]', 'c) [1, 2, 3]', 'd) [2, 3, 4]', 4),
(117, 23, 'Aptitude', 'BW3KYR', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(118, 34, 'Aptitude', 'BW3KYR', 'How do you add an element to the end of a list in Python?', 'a) list.add()', 'b) list.append()', 'c) list.push()', 'd) list.insert()', 2),
(119, 31, 'Aptitude', 'BW3KYR', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'a) True', 'b) False', 'c) 5', '4) Error', 1),
(120, 1, 'Analytical', 'Z1PKDN', 'Which financial ratio measures a company\'s ability to meet its short-term obligations?', 'A) Return on Equity (ROE)', 'B) Current Ratio', 'C) Debt-to-Equity Ratio', 'D) Gross Profit Margin', 2),
(121, 4, 'Analytical', 'Z1PKDN', 'In a linear regression model, what does the coefficient of an independent variable represent?', 'A) The average value of the dependent variable', 'B) The change in the dependent variable for a one-unit change in the independent variable', 'C) The total sum of squares of the dependent variable', 'D) The intercept of the regression line', 2),
(122, 19, 'Analytical', 'Z1PKDN', 'In the context of data science, what does the term \"feature\" refer to?', 'A) The target variable to be predicted', 'B) The output of the model', 'C) An individual measurable property or characteristic of a phenomenon being observed', 'D) The algorithm used for modeling', 3),
(123, 7, 'Analytical', 'Z1PKDN', 'Which machine learning algorithm is best suited for predicting stock prices?', 'A) K-means clustering', 'B) Linear regression', 'C) Decision trees', 'D) Apriori algorithm', 2),
(124, 20, 'Analytical', 'Z1PKDN', 'Which type of data visualization is used to show the distribution of a dataset?', 'A) Line chart', 'B) Scatter plot', 'C) Histogram', 'D) Pie chart', 3),
(125, 14, 'Analytical', 'Z1PKDN', 'In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3),
(126, 8, 'Analytical', 'Z1PKDN', 'What does \"over fitting\" mean in the context of machine learning?', 'A) The model performs poorly on training data but well on test data', 'B) The model performs well on training data but poorly on test data', 'C) The model uses too few features', 'D) The model is unable to make any predictions', 2),
(127, 12, 'Analytical', 'Z1PKDN', 'What does the term \"Big Data\" refer to in the context of financial analysis?', 'A) Large volumes of structured and unstructured data that can be analyzed for insights', 'B) Small, manageable sets of data used for daily operations', 'C) Data stored in traditional databases', 'D) Data primarily used for marketing purposes', 1),
(128, 9, 'Analytical', 'Z1PKDN', 'Which type of neural network is best suited for sequential data, such as financial time series?', 'A) Convolutional Neural Network (CNN)', 'B) Recurrent Neural Network (RNN)', 'C) Feedforward Neural Network', 'D) Generative Adversarial Network (GAN)', 2),
(129, 18, 'Analytical', 'Z1PKDN', 'What does the mean() function compute in statistics?', 'A) The median of a dataset', 'B) The mode of a dataset', 'C) The average value of a dataset', 'D) The range of a dataset', 3),
(130, 24, 'Python', 'CVB45Y', 'What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2),
(131, 21, 'Python', 'CVB45Y', 'Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(132, 27, 'Python', 'CVB45Y', 'What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2),
(133, 29, 'Python', 'CVB45Y', 'Which keyword is used to define a variable in Python?', 'a) var', 'b) def', 'c) int', 'd) No keyword is required', 4),
(134, 25, 'Python', 'CVB45Y', 'How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(135, 33, 'Python', 'CVB45Y', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', 'a) [2, 3]', 'b) [3, 4]', 'c) [1, 2, 3]', 'd) [2, 3, 4]', 4),
(136, 23, 'Python', 'CVB45Y', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(137, 31, 'Python', 'CVB45Y', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'a) True', 'b) False', 'c) 5', '4) Error', 1),
(138, 135, 'java', 'OEZ25F', 'In Java', ' which of the following is a wrapper class for `int`?', ' a) Integer', ' b) IntWrapper', ' c) IntegerWrapper', 0),
(139, 142, 'java', 'OEZ25F', 'Which of the following will compile correctly in Java?', ' a) String[] arr = new String[10];', ' b) String arr[] = new String[10];', ' c) Both a and b', ' d) None of the above', 3),
(140, 161, 'Java', 'OEZ25F', 'In Java', ' which of the following is a wrapper class for `int`?', ' a) Integer', ' b) IntWrapper', ' c) IntegerWrapper', 0),
(141, 164, 'Java', 'OEZ25F', 'In Java', ' which method is used to compare two strings?', ' a) compareTo()', ' b) equals()', ' c) compare()', 0),
(142, 132, 'java', 'OEZ25F', 'Which of the following is used to define a method in Java?', ' a) function', ' b) method', ' c) def', ' d) void', 4),
(143, 96, 'java', 'OEZ25F', 'In Java', ' which of the following will throw an exception?', ' a) int x = 10 / 0;', ' b) int x = 10 / 2;', ' c) int x = 10 % 2;', 0),
(144, 157, 'Java', 'OEZ25F', 'Which of the following keywords is used to create a class in Java?', ' a) class', ' b) object', ' c) def', ' d) function', 1),
(145, 129, 'java', 'OEZ25F', 'What is the size of a `long` data type in Java?', ' a) 32 bits', ' b) 64 bits', ' c) 16 bits', ' d) 128 bits', 2),
(146, 177, 'Java', 'OEZ25F', 'What does the `this` keyword refer to in Java?', ' a) The current class', ' b) The current object', ' c) The parent class', ' d) None of the above', 2),
(147, 106, 'java', 'OEZ25F', 'Which of the following is used to define a method in Java?', ' a) function', ' b) method', ' c) def', ' d) void', 4),
(148, 155, 'Java', 'OEZ25F', 'What is the size of a `long` data type in Java?', ' a) 32 bits', ' b) 64 bits', ' c) 16 bits', ' d) 128 bits', 2),
(149, 152, 'Java', 'OEZ25F', 'What is the correct syntax for creating a new object of the \'String\' class in Java?', ' a) String str = new String();', ' b) String str = \'new String\';', ' c) String str = \'String\';', ' d) String str = new String(\'Hello\');', 1),
(150, 109, 'java', 'OEZ25F', 'In Java', ' which of the following is a wrapper class for `int`?', ' a) Integer', ' b) IntWrapper', ' c) IntegerWrapper', 0),
(151, 94, 'java', 'OEZ25F', 'What does the \'final\' keyword do in Java?', ' a) It makes the variable constant', ' b) It makes the method final and cannot be overridden', ' c) It prevents inheritance of a class', ' d) All of the above', 4),
(152, 118, 'java', 'OEZ25F', 'What does the `super()` keyword do in Java?', ' a) Calls the constructor of the parent class', ' b) Calls the method of the parent class', ' c) It refers to the current class', ' d) None of the above', 1),
(153, 165, 'Java', 'OEZ25F', 'Which of the following is true about the `ArrayList` class in Java?', ' a) It is a part of the Java collection framework', ' b) It allows duplicate elements', ' c) It resizes dynamically', ' d) All of the above', 4),
(154, 175, 'Java', 'OEZ25F', 'What is the default value of a reference variable in Java?', ' a) null', ' b) 0', ' c) false', ' d) Undefined', 1),
(155, 101, 'java', 'OEZ25F', 'Which method is used to find the length of a string in Java?', ' a) length()', ' b) size()', ' c) getSize()', ' d) getLength()', 1),
(156, 134, 'java', 'OEZ25F', 'Which of the following is true about the `String` class in Java?', ' a) It is mutable', ' b) It is immutable', ' c) It is thread-unsafe', ' d) It is an abstract class', 2),
(157, 159, 'Java', 'OEZ25F', 'Which exception does the code `Thread.sleep(-1000);` throw in Java?', ' a) IllegalArgumentException', ' b) InterruptedException', ' c) ArithmeticException', ' d) NullPointerException', 1),
(158, 113, 'java', 'OEZ25F', 'Which of the following is true about the `ArrayList` class in Java?', ' a) It is a part of the Java collection framework', ' b) It allows duplicate elements', ' c) It resizes dynamically', ' d) All of the above', 4),
(159, 153, 'Java', 'OEZ25F', 'Which method is used to find the length of a string in Java?', ' a) length()', ' b) size()', ' c) getSize()', ' d) getLength()', 1),
(160, 138, 'java', 'OEZ25F', 'In Java', ' which method is used to compare two strings?', ' a) compareTo()', ' b) equals()', ' c) compare()', 0),
(161, 163, 'Java', 'OEZ25F', 'What is the default value of an instance variable in Java?', ' a) null', ' b) 0', ' c) false', ' d) Depends on the type', 4),
(162, 21, 'Python', 'GDEMQT', 'Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(163, 27, 'Python', 'GDEMQT', 'What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2),
(164, 32, 'Python', 'GDEMQT', 'Which of the following is not a valid data type in Python?', 'a)	int', 'b)	float', 'c)	real', 'd)	str', 3),
(165, 33, 'Python', 'GDEMQT', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', 'a) [2, 3]', 'b) [3, 4]', 'c) [1, 2, 3]', 'd) [2, 3, 4]', 4),
(166, 25, 'Python', 'GDEMQT', 'How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(167, 22, 'Python', 'GDEMQT', 'Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3),
(168, 26, 'Python', 'GDEMQT', 'Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1),
(169, 34, 'Python', 'GDEMQT', 'How do you add an element to the end of a list in Python?', 'a) list.add()', 'b) list.append()', 'c) list.push()', 'd) list.insert()', 2),
(170, 31, 'Python', 'GDEMQT', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'a) True', 'b) False', 'c) 5', '4) Error', 1),
(171, 23, 'Python', 'GDEMQT', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(172, 10, 'Aptitude', 'DXOEZJ', 'What is the purpose of the train-test split in machine learning?', 'A) To increase the size of the training data', 'B) To ensure the model is not overfitting', 'C) To optimize the model\\\'s hyperparameters', 'D) To validate the model on unseen data', 4),
(173, 14, 'Aptitude', 'DXOEZJ', 'In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3),
(174, 12, 'Aptitude', 'DXOEZJ', 'What does the term \"Big Data\" refer to in the context of financial analysis?', 'A) Large volumes of structured and unstructured data that can be analyzed for insights', 'B) Small, manageable sets of data used for daily operations', 'C) Data stored in traditional databases', 'D) Data primarily used for marketing purposes', 1),
(175, 32, 'Aptitude', 'DXOEZJ', 'Which of the following is not a valid data type in Python?', 'a)	int', 'b)	float', 'c)	real', 'd)	str', 3),
(176, 33, 'Aptitude', 'DXOEZJ', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', 'a) [2, 3]', 'b) [3, 4]', 'c) [1, 2, 3]', 'd) [2, 3, 4]', 4),
(177, 23, 'Aptitude', 'DXOEZJ', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(178, 21, 'Python', 'LHB64U', 'Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2),
(179, 24, 'Python', 'LHB64U', 'What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2),
(180, 27, 'Python', 'LHB64U', 'What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2),
(181, 33, 'Python', 'LHB64U', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', 'a) [2, 3]', 'b) [3, 4]', 'c) [1, 2, 3]', 'd) [2, 3, 4]', 4),
(182, 29, 'Python', 'LHB64U', 'Which keyword is used to define a variable in Python?', 'a) var', 'b) def', 'c) int', 'd) No keyword is required', 4),
(183, 25, 'Python', 'LHB64U', 'How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(184, 23, 'Python', 'LHB64U', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(185, 31, 'Python', 'LHB64U', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'a) True', 'b) False', 'c) 5', '4) Error', 1),
(186, 26, 'Python', 'LHB64U', 'Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1),
(187, 34, 'Python', 'LHB64U', 'How do you add an element to the end of a list in Python?', 'a) list.add()', 'b) list.append()', 'c) list.push()', 'd) list.insert()', 2),
(188, 7, 'Aptitude', 'AKJMUI', 'Which machine learning algorithm is best suited for predicting stock prices?', 'A) K-means clustering', 'B) Linear regression', 'C) Decision trees', 'D) Apriori algorithm', 2),
(189, 1, 'Aptitude', 'AKJMUI', 'Which financial ratio measures a company\'s ability to meet its short-term obligations?', 'A) Return on Equity (ROE)', 'B) Current Ratio', 'C) Debt-to-Equity Ratio', 'D) Gross Profit Margin', 2),
(190, 20, 'Aptitude', 'AKJMUI', 'Which type of data visualization is used to show the distribution of a dataset?', 'A) Line chart', 'B) Scatter plot', 'C) Histogram', 'D) Pie chart', 3),
(191, 2, 'Aptitude', 'AKJMUI', 'In Python, which library is commonly used for data manipulation and analysis?', 'A) NumPy', 'B) Matplotlib', 'C) Pandas', 'D) Scikit-learn', 3),
(192, 6, 'Aptitude', 'AKJMUI', 'What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2),
(193, 12, 'Aptitude', 'AKJMUI', 'What does the term \"Big Data\" refer to in the context of financial analysis?', 'A) Large volumes of structured and unstructured data that can be analyzed for insights', 'B) Small, manageable sets of data used for daily operations', 'C) Data stored in traditional databases', 'D) Data primarily used for marketing purposes', 1),
(194, 27, 'Aptitude', 'AKJMUI', 'What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2),
(195, 24, 'Aptitude', 'AKJMUI', 'What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2),
(196, 33, 'Aptitude', 'AKJMUI', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', 'a) [2, 3]', 'b) [3, 4]', 'c) [1, 2, 3]', 'd) [2, 3, 4]', 4),
(197, 25, 'Aptitude', 'AKJMUI', 'How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3),
(198, 26, 'Aptitude', 'AKJMUI', 'Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1),
(199, 23, 'Aptitude', 'AKJMUI', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2),
(200, 331, 'Python', '2GPIY6', 'Which of the following is a mutable data type in Python?', 'Tuple', 'String', 'List', 'Set', 3),
(201, 334, 'Python', '2GPIY6', 'Which method is used to add an item to a list?', 'append()', 'add()', 'insert()', 'extend()', 1),
(202, 364, 'Python', '2GPIY6', 'Which of the following is used to handle exceptions in Python?', 'try-except', 'catch-throw', 'handle()', 'error-catch', 1),
(203, 32, 'Python', '2GPIY6', 'Which of the following is not a valid data type in Python?', 'int', 'float', 'real', 'str', 3),
(204, 377, 'Python', '2GPIY6', 'What is the result of type(10) in Python?', '<class \'int\'>', 'int', 'integer', '<type \'int\'>', 1),
(205, 355, 'Python', '2GPIY6', 'Which of the following is used to check if a key exists in a dictionary?', 'exists()', 'in', 'has_key()', 'find()', 2),
(206, 353, 'Python', '2GPIY6', 'Which method is used to remove an item from a dictionary?', 'remove()', 'del', 'discard()', 'pop()', 4),
(207, 33, 'Python', '2GPIY6', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', '[2, 3]', '[3, 4]', '[1, 2, 3]', '[2, 3, 4]', 4),
(208, 372, 'Python', '2GPIY6', 'What will be the result of \'Hello\'.find(\'e\')?', '1', '2', '3', '-1', 2),
(209, 29, 'Python', '2GPIY6', 'Which keyword is used to define a variable in Python?', 'var', 'def', 'int', 'No keyword is required', 4),
(210, 25, 'Python', '2GPIY6', 'How do you insert a comment in Python code?', '// This is a comment', '/* This is a comment */', ' # This is a comment', '-- This is a comment', 3),
(211, 370, 'Python', '2GPIY6', 'Which of the following is an assignment operator?', '==', '=', '===', '=>', 2),
(212, 373, 'Python', '2GPIY6', 'Which function is used to get a substring from a string?', 'substr()', 'slice()', 'substring()', 'split()', 2),
(213, 360, 'Python', '2GPIY6', 'What does the \'pass\' keyword do?', 'Terminates the loop', 'Skips the current iteration', 'Does nothing', 'Raises an error', 3),
(214, 348, 'Python', '2GPIY6', 'Which function is used to convert a string to an integer?', 'str()', 'int()', 'float()', 'toInt()', 2),
(215, 336, 'Python', '2GPIY6', 'Which statement is used to exit a loop?', 'return', 'exit', 'break', 'stop', 3);

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
(85, 16, 'Python', 200, 'Which of the following is a mutable data type in Python?', 3, 3, 'Correct', '2025-02-09 14:48:06'),
(86, 16, 'Python', 201, 'Which method is used to add an item to a list?', 2, 1, 'Incorrect', '2025-02-09 14:48:06'),
(87, 16, 'Python', 202, 'Which of the following is used to handle exceptions in Python?', 2, 1, 'Incorrect', '2025-02-09 14:48:06'),
(88, 16, 'Python', 203, 'Which of the following is not a valid data type in Python?', 1, 3, 'Incorrect', '2025-02-09 14:48:06'),
(89, 16, 'Python', 204, 'What is the result of type(10) in Python?', 2, 1, 'Incorrect', '2025-02-09 14:48:06'),
(90, 16, 'Python', 205, 'Which of the following is used to check if a key exists in a dictionary?', 2, 2, 'Correct', '2025-02-09 14:48:06'),
(91, 16, 'Python', 206, 'Which method is used to remove an item from a dictionary?', 3, 4, 'Incorrect', '2025-02-09 14:48:06'),
(92, 16, 'Python', 207, 'What is the output of the following code?<br>\\\\r\\\\na = [1, 2, 3, 4, 5]<br>\\\\r\\\\nprint(a[2:4])<br>\\\\r\\\\n', 2, 4, 'Incorrect', '2025-02-09 14:48:06'),
(93, 16, 'Python', 208, 'What will be the result of \\\'Hello\\\'.find(\\\'e\\\')?', 3, 2, 'Incorrect', '2025-02-09 14:48:06'),
(94, 16, 'Python', 209, 'Which keyword is used to define a variable in Python?', 2, 4, 'Incorrect', '2025-02-09 14:48:06'),
(95, 16, 'Python', 210, 'How do you insert a comment in Python code?', 3, 3, 'Correct', '2025-02-09 14:48:06'),
(96, 16, 'Python', 211, 'Which of the following is an assignment operator?', 3, 2, 'Incorrect', '2025-02-09 14:48:06'),
(97, 16, 'Python', 212, 'Which function is used to get a substring from a string?', 4, 2, 'Incorrect', '2025-02-09 14:48:06'),
(98, 16, 'Python', 213, 'What does the \\\'pass\\\' keyword do?', 2, 3, 'Incorrect', '2025-02-09 14:48:06'),
(99, 16, 'Python', 214, 'Which function is used to convert a string to an integer?', 2, 2, 'Correct', '2025-02-09 14:48:06'),
(100, 16, 'Python', 215, 'Which statement is used to exit a loop?', 2, 3, 'Incorrect', '2025-02-09 14:48:06');

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
(14, 16, 'Python', 4);

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
-- Indexes for table `candidate_personal_details`
--
ALTER TABLE `candidate_personal_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_id` (`candidate_id`);

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
-- Indexes for table `menu`
--
ALTER TABLE `menu`
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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `candidate_personal_details`
--
ALTER TABLE `candidate_personal_details`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exam_type_menu`
--
ALTER TABLE `exam_type_menu`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mcq_questions`
--
ALTER TABLE `mcq_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `question_results`
--
ALTER TABLE `question_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate_personal_details`
--
ALTER TABLE `candidate_personal_details`
  ADD CONSTRAINT `candidate_personal_details_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;

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
