-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 07:21 AM
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
(1, 'info@admin.com', '$2y$10$pISRXxGrnxpgbJ0oiuspe.UlRHkotTAoXVKYDnfFsFLJG5kQgrfLS');

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
(16, 'Baski Saw', '7488162756', 'baski12.kumar@gmail.com', '$2y$10$C2O4hR8VUrZnuARMBmg4xeknABfvhzKzB0.DqG6.bHlVEY9JYN1bS', 'Python', 'Software Developer', 10, 6, 'R9V6Y2', '3600', 'Completed', 1),
(17, 'Manoj Kumar', '9876567898', 'manoj@gmail.com', '$2y$10$Q3LiK4rGm7ORDJi6ob9myuAojt9ziSFwwOQy0BM21e.uUtZAl5RLq', 'Python', 'Software Developer', 0, 6, 'GDEMQT', '3600', 'Completed', 1),
(18, 'Krishna Kumar', '8977652356', 'krishna@gmail.com', '$2y$10$FnSRCQU.0sABcqmGwAYl4e5ocRp3TroQ7IBCMKNg/pYGidGR6L8eS', 'Python', 'Software Developer', 0, 5, 'LHB64U', '3600', 'Completed', 1),
(19, 'Basanti Kumari Mandal', '7250126243', 'basanti@gmail.com', '$2y$10$NIl1eVD.7tGUEnfR15nJZ.RUZp6JUXjSTajC24ZnrsM.qDsoovSLq', 'Python', 'Software Developer', 8, 3, 'CVB45Y', '3600', 'Completed', 1),
(20, 'Manoj Kumar', '8809815253', 'manojaarav685@gmail.com', '$2y$10$PJv9MZeRIV7n8lszmaVi3eHtxNvTzEWrwIiuz4pVuhBac1LkEAoe6', 'Python', 'Software Developer', 8, 7, 'CVB45Y', '3600', 'Completed', 1),
(21, 'Anshu', '9876789876', 'anshu@gmail.com', '$2y$10$s9n3Np6yMgFWGmRkhWGdGOPeWmFhV0fdiMxuM2MrjSaXEr1shUAdS', 'Java', 'Software Developer', 0, 0, '', '3600', '', 0);

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
(4, 18, '2025-02-04', 'Male', 'Indian', 'Dhaiya ,Dhanbad', 'Dhanbad', 'Jharkhand', '826004', '2025-02-06 11:17:34'),
(5, 20, '1989-10-05', 'Male', 'Indian', 'Middle School Road ,Dhaiya ,Dhanbad', 'Dhanbad', 'Jharkhand', '826004', '2025-02-11 17:29:27');

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
(9, 'PHP', 1),
(10, 'HTML', 1);

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
(377, 'Python', 'What is the result of type(10) in Python?', '<class \'int\'>', 'int', 'integer', '<type \'int\'>', 1, 1, 1),
(378, 'Java', 'What is the answer to question 1?', 'Option 1 for Q1', 'Option 2 for Q1', 'Option 3 for Q1', 'Option 4 for Q1', 1, 3, 1),
(379, 'Java', 'What is the answer to question 2?', 'Option 1 for Q2', 'Option 2 for Q2', 'Option 3 for Q2', 'Option 4 for Q2', 4, 3, 1),
(380, 'Java', 'What is the answer to question 3?', 'Option 1 for Q3', 'Option 2 for Q3', 'Option 3 for Q3', 'Option 4 for Q3', 2, 2, 1),
(381, 'Java', 'What is the answer to question 4?', 'Option 1 for Q4', 'Option 2 for Q4', 'Option 3 for Q4', 'Option 4 for Q4', 4, 2, 1),
(382, 'Java', 'What is the answer to question 5?', 'Option 1 for Q5', 'Option 2 for Q5', 'Option 3 for Q5', 'Option 4 for Q5', 3, 3, 1),
(383, 'Java', 'What is the answer to question 6?', 'Option 1 for Q6', 'Option 2 for Q6', 'Option 3 for Q6', 'Option 4 for Q6', 3, 1, 1),
(384, 'Java', 'What is the answer to question 7?', 'Option 1 for Q7', 'Option 2 for Q7', 'Option 3 for Q7', 'Option 4 for Q7', 2, 2, 1),
(385, 'Java', 'What is the answer to question 8?', 'Option 1 for Q8', 'Option 2 for Q8', 'Option 3 for Q8', 'Option 4 for Q8', 1, 3, 1),
(386, 'Java', 'What is the answer to question 9?', 'Option 1 for Q9', 'Option 2 for Q9', 'Option 3 for Q9', 'Option 4 for Q9', 4, 3, 1),
(387, 'Java', 'What is the answer to question 10?', 'Option 1 for Q10', 'Option 2 for Q10', 'Option 3 for Q10', 'Option 4 for Q10', 4, 2, 1),
(388, 'Java', 'What is the answer to question 11?', 'Option 1 for Q11', 'Option 2 for Q11', 'Option 3 for Q11', 'Option 4 for Q11', 2, 2, 1),
(389, 'Java', 'What is the answer to question 12?', 'Option 1 for Q12', 'Option 2 for Q12', 'Option 3 for Q12', 'Option 4 for Q12', 3, 1, 1),
(390, 'Java', 'What is the answer to question 13?', 'Option 1 for Q13', 'Option 2 for Q13', 'Option 3 for Q13', 'Option 4 for Q13', 3, 2, 1),
(391, 'Java', 'What is the answer to question 14?', 'Option 1 for Q14', 'Option 2 for Q14', 'Option 3 for Q14', 'Option 4 for Q14', 3, 2, 1),
(392, 'Java', 'What is the answer to question 15?', 'Option 1 for Q15', 'Option 2 for Q15', 'Option 3 for Q15', 'Option 4 for Q15', 1, 3, 1),
(393, 'Java', 'What is the answer to question 16?', 'Option 1 for Q16', 'Option 2 for Q16', 'Option 3 for Q16', 'Option 4 for Q16', 1, 1, 1),
(394, 'Java', 'What is the answer to question 17?', 'Option 1 for Q17', 'Option 2 for Q17', 'Option 3 for Q17', 'Option 4 for Q17', 4, 1, 1),
(395, 'Java', 'What is the answer to question 18?', 'Option 1 for Q18', 'Option 2 for Q18', 'Option 3 for Q18', 'Option 4 for Q18', 2, 2, 1),
(396, 'Java', 'What is the answer to question 19?', 'Option 1 for Q19', 'Option 2 for Q19', 'Option 3 for Q19', 'Option 4 for Q19', 1, 1, 1),
(397, 'Java', 'What is the answer to question 20?', 'Option 1 for Q20', 'Option 2 for Q20', 'Option 3 for Q20', 'Option 4 for Q20', 4, 2, 1),
(398, 'Java', 'What is the answer to question 21?', 'Option 1 for Q21', 'Option 2 for Q21', 'Option 3 for Q21', 'Option 4 for Q21', 3, 3, 1),
(399, 'Java', 'What is the answer to question 22?', 'Option 1 for Q22', 'Option 2 for Q22', 'Option 3 for Q22', 'Option 4 for Q22', 3, 3, 1),
(400, 'Java', 'What is the answer to question 23?', 'Option 1 for Q23', 'Option 2 for Q23', 'Option 3 for Q23', 'Option 4 for Q23', 4, 3, 1),
(401, 'Java', 'What is the answer to question 24?', 'Option 1 for Q24', 'Option 2 for Q24', 'Option 3 for Q24', 'Option 4 for Q24', 3, 2, 1),
(402, 'Java', 'What is the answer to question 25?', 'Option 1 for Q25', 'Option 2 for Q25', 'Option 3 for Q25', 'Option 4 for Q25', 1, 3, 1),
(403, 'Java', 'What is the answer to question 26?', 'Option 1 for Q26', 'Option 2 for Q26', 'Option 3 for Q26', 'Option 4 for Q26', 4, 3, 1),
(404, 'Java', 'What is the answer to question 27?', 'Option 1 for Q27', 'Option 2 for Q27', 'Option 3 for Q27', 'Option 4 for Q27', 1, 3, 1),
(405, 'Java', 'What is the answer to question 28?', 'Option 1 for Q28', 'Option 2 for Q28', 'Option 3 for Q28', 'Option 4 for Q28', 3, 3, 1),
(406, 'Java', 'What is the answer to question 29?', 'Option 1 for Q29', 'Option 2 for Q29', 'Option 3 for Q29', 'Option 4 for Q29', 3, 3, 1),
(407, 'Java', 'What is the answer to question 30?', 'Option 1 for Q30', 'Option 2 for Q30', 'Option 3 for Q30', 'Option 4 for Q30', 3, 1, 1),
(408, 'Java', 'What is the answer to question 31?', 'Option 1 for Q31', 'Option 2 for Q31', 'Option 3 for Q31', 'Option 4 for Q31', 2, 3, 1),
(409, 'Java', 'What is the answer to question 32?', 'Option 1 for Q32', 'Option 2 for Q32', 'Option 3 for Q32', 'Option 4 for Q32', 2, 3, 1),
(410, 'Java', 'What is the answer to question 33?', 'Option 1 for Q33', 'Option 2 for Q33', 'Option 3 for Q33', 'Option 4 for Q33', 4, 2, 1),
(411, 'Java', 'What is the answer to question 34?', 'Option 1 for Q34', 'Option 2 for Q34', 'Option 3 for Q34', 'Option 4 for Q34', 3, 1, 1),
(412, 'Java', 'What is the answer to question 35?', 'Option 1 for Q35', 'Option 2 for Q35', 'Option 3 for Q35', 'Option 4 for Q35', 2, 3, 1),
(413, 'Java', 'What is the answer to question 36?', 'Option 1 for Q36', 'Option 2 for Q36', 'Option 3 for Q36', 'Option 4 for Q36', 3, 1, 1),
(414, 'Java', 'What is the answer to question 37?', 'Option 1 for Q37', 'Option 2 for Q37', 'Option 3 for Q37', 'Option 4 for Q37', 3, 3, 1),
(415, 'Java', 'What is the answer to question 38?', 'Option 1 for Q38', 'Option 2 for Q38', 'Option 3 for Q38', 'Option 4 for Q38', 2, 3, 1),
(416, 'Java', 'What is the answer to question 39?', 'Option 1 for Q39', 'Option 2 for Q39', 'Option 3 for Q39', 'Option 4 for Q39', 2, 1, 1),
(417, 'Java', 'What is the answer to question 40?', 'Option 1 for Q40', 'Option 2 for Q40', 'Option 3 for Q40', 'Option 4 for Q40', 1, 2, 1),
(418, 'Java', 'What is the answer to question 41?', 'Option 1 for Q41', 'Option 2 for Q41', 'Option 3 for Q41', 'Option 4 for Q41', 4, 2, 1),
(419, 'Java', 'What is the answer to question 42?', 'Option 1 for Q42', 'Option 2 for Q42', 'Option 3 for Q42', 'Option 4 for Q42', 1, 1, 1),
(420, 'Java', 'What is the answer to question 43?', 'Option 1 for Q43', 'Option 2 for Q43', 'Option 3 for Q43', 'Option 4 for Q43', 1, 2, 1),
(421, 'Java', 'What is the answer to question 44?', 'Option 1 for Q44', 'Option 2 for Q44', 'Option 3 for Q44', 'Option 4 for Q44', 3, 2, 1),
(422, 'Java', 'What is the answer to question 45?', 'Option 1 for Q45', 'Option 2 for Q45', 'Option 3 for Q45', 'Option 4 for Q45', 4, 1, 1),
(423, 'Java', 'What is the answer to question 46?', 'Option 1 for Q46', 'Option 2 for Q46', 'Option 3 for Q46', 'Option 4 for Q46', 1, 3, 1),
(424, 'Java', 'What is the answer to question 47?', 'Option 1 for Q47', 'Option 2 for Q47', 'Option 3 for Q47', 'Option 4 for Q47', 4, 2, 1),
(425, 'Java', 'What is the answer to question 48?', 'Option 1 for Q48', 'Option 2 for Q48', 'Option 3 for Q48', 'Option 4 for Q48', 4, 2, 1),
(426, 'Java', 'What is the answer to question 49?', 'Option 1 for Q49', 'Option 2 for Q49', 'Option 3 for Q49', 'Option 4 for Q49', 4, 3, 1),
(427, 'Java', 'What is the answer to question 50?', 'Option 1 for Q50', 'Option 2 for Q50', 'Option 3 for Q50', 'Option 4 for Q50', 1, 1, 1);

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
(238, 21, 'Python', 'R9V6Y2', 'Which of the following is the correct extension of Python files?', '.python', '.py', '.pyt', '.pyc', 2),
(239, 340, 'Python', 'R9V6Y2', 'What is the output of len(\'Python\')?', '5', '6', '7', 'Error', 2),
(240, 371, 'Python', 'R9V6Y2', 'What will be the result of bool(\'False\')?', 'True', 'False', 'Error', 'None', 1),
(241, 372, 'Python', 'R9V6Y2', 'What will be the result of \'Hello\'.find(\'e\')?', '1', '2', '3', '-1', 2),
(242, 353, 'Python', 'R9V6Y2', 'Which method is used to remove an item from a dictionary?', 'remove()', 'del', 'discard()', 'pop()', 4),
(243, 25, 'Python', 'R9V6Y2', 'How do you insert a comment in Python code?', '// This is a comment', '/* This is a comment */', ' # This is a comment', '-- This is a comment', 3),
(244, 336, 'Python', 'R9V6Y2', 'Which statement is used to exit a loop?', 'return', 'exit', 'break', 'stop', 3),
(245, 370, 'Python', 'R9V6Y2', 'Which of the following is an assignment operator?', '==', '=', '===', '=>', 2),
(246, 376, 'Python', 'R9V6Y2', 'Which function converts an integer to a string?', 'str()', 'string()', 'toString()', 'convert()', 1),
(247, 348, 'Python', 'R9V6Y2', 'Which function is used to convert a string to an integer?', 'str()', 'int()', 'float()', 'toInt()', 2);

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
(155, 16, 'Python', 238, 'Which of the following is the correct extension of Python files?', 2, 2, 'Correct', '2025-02-13 05:00:58'),
(156, 16, 'Python', 239, 'What is the output of len(\\\'Python\\\')?', 2, 2, 'Correct', '2025-02-13 05:00:58'),
(157, 16, 'Python', 240, 'What will be the result of bool(\\\'False\\\')?', 1, 1, 'Correct', '2025-02-13 05:00:58'),
(158, 16, 'Python', 241, 'What will be the result of \\\'Hello\\\'.find(\\\'e\\\')?', 2, 2, 'Correct', '2025-02-13 05:00:58'),
(159, 16, 'Python', 242, 'Which method is used to remove an item from a dictionary?', 2, 4, 'Incorrect', '2025-02-13 05:00:58'),
(160, 16, 'Python', 243, 'How do you insert a comment in Python code?', 3, 3, 'Correct', '2025-02-13 05:00:58'),
(161, 16, 'Python', 244, 'Which statement is used to exit a loop?', 3, 3, 'Correct', '2025-02-13 05:00:58'),
(162, 16, 'Python', 245, 'Which of the following is an assignment operator?', 3, 2, 'Incorrect', '2025-02-13 05:00:58'),
(163, 16, 'Python', 246, 'Which function converts an integer to a string?', 2, 1, 'Incorrect', '2025-02-13 05:00:58'),
(164, 16, 'Python', 247, 'Which function is used to convert a string to an integer?', 3, 2, 'Incorrect', '2025-02-13 05:00:58');

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
(21, 16, 'Python', 6);

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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `candidate_personal_details`
--
ALTER TABLE `candidate_personal_details`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_type_menu`
--
ALTER TABLE `exam_type_menu`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `question_results`
--
ALTER TABLE `question_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
