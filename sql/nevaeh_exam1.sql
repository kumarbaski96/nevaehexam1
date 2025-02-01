-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 02:11 PM
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
(16, 'Baski Saw', '7488162756', 'baski12.kumar@gmail.com', '$2y$10$LRCnEWS/rcbayy2JJHTIJuEhrBVQ9OTYqYr.2UlapYyjN6kg/yxKi', 'Python', 'Software Developer', 4, 'CVB45Y', '1800', 'Completed', 1);

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
(3, 16, '1992-09-07', 'Male', 'Indian', 'Meddle School Road,Dhaiya ,Dhanbad', 'Dhanbad', 'Jharkhand', '826004', '2025-02-01 04:34:34');

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
(5, 'C++', 0),
(6, 'Aptitude', 1),
(7, 'Java', 1);

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
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `parent_id`) VALUES
(1, 'Dashboard', 0),
(2, 'Manage Users', 0),
(3, 'Reports', 0),
(4, 'Settings', 0),
(5, 'Add User', 2),
(6, 'View Users', 2),
(7, 'Daily Reports', 3),
(8, 'Monthly Reports', 3),
(9, 'Profile', 0),
(10, 'Preferences', 4),
(26, 'Notification Settings', 4),
(27, 'Overview', 1),
(28, 'Statistics', 1),
(29, 'Recent Activity', 1);

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
(1, 'Analytical', 'Which financial ratio measures a company\'s ability to meet its short-term obligations?', 'A) Return on Equity (ROE)', 'B) Current Ratio', 'C) Debt-to-Equity Ratio', 'D) Gross Profit Margin', 2, 1, 1),
(2, 'Analytical', 'In Python, which library is commonly used for data manipulation and analysis?', 'A) NumPy', 'B) Matplotlib', 'C) Pandas', 'D) Scikit-learn', 3, 2, 1),
(3, 'Analytical', 'Which of these describes the Debt-to-Equity Ratio?', 'A) A measure of a company\'s profitability', 'B) A ratio comparing the company\'s total liabilities to its shareholder equity', 'C) A ratio assessing the efficiency of a company\'s operations', 'D) A measure of the company\'s market value', 2, 3, 1),
(4, 'Analytical', 'In a linear regression model, what does the coefficient of an independent variable represent?', 'A) The average value of the dependent variable', 'B) The change in the dependent variable for a one-unit change in the independent variable', 'C) The total sum of squares of the dependent variable', 'D) The intercept of the regression line', 2, 1, 1),
(5, 'Analytical', 'What is the purpose of the R-squared value in regression analysis?', 'A) To measure the strength and direction of the linear relationship between two variables', 'B) To determine the significance of regression coefficients', 'C) To quantify the proportion of variation in the dependent variable explained by the independent variables', 'D) To test for the presence of multicollinearity', 3, 2, 1),
(6, 'Analytical', 'What is the primary purpose of a confusion matrix in evaluating a classification model?', 'A) To summarize the performance of a regression model', 'B) To display the true positives, true negatives, false positives, and false negatives', 'C) To visualize the distribution of data', 'D) To calculate the mean absolute error', 2, 3, 1),
(7, 'Analytical', 'Which machine learning algorithm is best suited for predicting stock prices?', 'A) K-means clustering', 'B) Linear regression', 'C) Decision trees', 'D) Apriori algorithm', 2, 1, 1),
(8, 'Analytical', 'What does \"over fitting\" mean in the context of machine learning?', 'A) The model performs poorly on training data but well on test data', 'B) The model performs well on training data but poorly on test data', 'C) The model uses too few features', 'D) The model is unable to make any predictions', 2, 2, 1),
(9, 'Analytical', 'Which type of neural network is best suited for sequential data, such as financial time series?', 'A) Convolutional Neural Network (CNN)', 'B) Recurrent Neural Network (RNN)', 'C) Feedforward Neural Network', 'D) Generative Adversarial Network (GAN)', 2, 3, 1),
(10, 'Analytical', 'What is the purpose of the train-test split in machine learning?', 'A) To increase the size of the training data', 'B) To ensure the model is not overfitting', 'C) To optimize the model\\\'s hyperparameters', 'D) To validate the model on unseen data', 4, 1, 1),
(11, 'Analytical', 'In financial forecasting, which method involves using historical data to predict future financial performance?', 'A) Monte Carlo Simulation', 'B) Time Series Analysis', 'C) SWOT Analysis', 'D) PEST Analysis', 2, 2, 1),
(12, 'Analytical', 'What does the term \"Big Data\" refer to in the context of financial analysis?', 'A) Large volumes of structured and unstructured data that can be analyzed for insights', 'B) Small, manageable sets of data used for daily operations', 'C) Data stored in traditional databases', 'D) Data primarily used for marketing purposes', 1, 3, 1),
(13, 'Analytical', 'In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3, 1, 1),
(14, 'Analytical', 'In logistic regression, what type of dependent variable is used?', 'A) Continuous', 'B) Ordinal', 'C) Binary', 'D) Nominal with more than two categories', 3, 2, 1),
(15, 'Analytical', 'Which function is used to compute descriptive statistics of a DataFrame in Pandas?', 'A) df.stats()', 'B) df.summary()', 'C) df.describe()', 'D) df.detail()', 3, 3, 1),
(16, 'Analytical', 'How do you handle missing values in a DataFrame?', 'A) df.dropna()', 'B) df.fillna()', 'C) df.replace_na()', 'D) Both A and B', 4, 1, 1),
(17, 'Analytical', 'What SQL statement is used to retrieve data from a database?', 'A) GET', 'B) SELECT', 'C) RETRIEVE', 'D) EXTRACT', 2, 2, 1),
(18, 'Analytical', 'What does the mean() function compute in statistics?', 'A) The median of a dataset', 'B) The mode of a dataset', 'C) The average value of a dataset', 'D) The range of a dataset', 3, 3, 1),
(19, 'Analytical', 'In the context of data science, what does the term \"feature\" refer to?', 'A) The target variable to be predicted', 'B) The output of the model', 'C) An individual measurable property or characteristic of a phenomenon being observed', 'D) The algorithm used for modeling', 3, 1, 1),
(20, 'Analytical', 'Which type of data visualization is used to show the distribution of a dataset?', 'A) Line chart', 'B) Scatter plot', 'C) Histogram', 'D) Pie chart', 3, 2, 1),
(21, 'Python', 'Which of the following is the correct extension of Python files?', 'a) .python', 'b) .py', 'c) .pyt', 'd) .pyc', 2, 1, 1),
(22, 'Python', 'Which of the following is used to define a block of code in Python?', 'a) Curly braces {}', 'b) Parentheses ()', 'c) Indentation', 'd) Semi-colon ;', 3, 2, 1),
(23, 'Python', 'What will be the output of the following code?<br>print(type(2))', 'a) <class \'float\'>', 'b) <class \'int\'>', 'c) <class \'bool\'>', 'd) <class \'NoneType\'>', 2, 3, 1),
(24, 'Python', 'What is the correct syntax to create a function in Python?', 'a) function myFunction():', 'b) def myFunction():', 'c) create myFunction():', 'd) function: myFunction()', 2, 1, 1),
(25, 'Python', 'How do you insert a comment in Python code?', 'a)// This is a comment', 'b) /* This is a comment */', 'c) # This is a comment', 'd) -- This is a comment', 3, 2, 1),
(26, 'Python', 'Which of the following will create a list in Python?', 'a)	[1, 2, 3]', 'b)	(1, 2, 3)', 'c)	{1, 2, 3}', 'd)	1, 2, 3', 1, 3, 1),
(27, 'Python', 'What does the len() function do?', 'a) Returns the length of a string', 'b) Returns the length of a list or string', 'c) Returns the size of the memory used by an object', 'd) Counts the number of spaces in a string', 2, 1, 1),
(29, 'Python', 'Which keyword is used to define a variable in Python?', 'a) var', 'b) def', 'c) int', 'd) No keyword is required', 4, 2, 1),
(31, 'Python', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'a) True', 'b) False', 'c) 5', '4) Error', 1, 3, 1),
(32, 'Python', 'Which of the following is not a valid data type in Python?', 'a)	int', 'b)	float', 'c)	real', 'd)	str', 3, 1, 1),
(33, 'Python', 'What is the output of the following code?<br>\\r\\na = [1, 2, 3, 4, 5]<br>\\r\\nprint(a[2:4])<br>\\r\\n', 'a) [2, 3]', 'b) [3, 4]', 'c) [1, 2, 3]', 'd) [2, 3, 4]', 4, 2, 1),
(34, 'Python', 'How do you add an element to the end of a list in Python?', 'a) list.add()', 'b) list.append()', 'c) list.push()', 'd) list.insert()', 2, 3, 1),
(35, 'Java', 'Which of the following is not a Java keyword?', 'a) static', 'a) void', 'c) main', 'd) final', 3, 1, 0),
(36, 'Java', 'Which of the following is used to compile a Java program?', 'java', 'javac', 'jvm', 'jre', 2, 2, 1),
(37, 'Java', 'What will be the output of System.out.println(10/3); in Java?', '3', '3.33', '3.0', '10/3', 1, 3, 1),
(38, 'Java', 'What is the size of the char data type in Java?', '1 byte', '2 bytes', '4 bytes', '8 bytes', 2, 1, 1),
(39, 'Java', 'Which of these is not a wrapper class in Java?', 'Integer', 'Float', 'Character', 'String', 4, 2, 1),
(40, 'Java', 'What is the base class for all Java classes?', 'Object', 'Class', 'Super', 'Base', 1, 3, 1),
(41, 'Java', 'Which of the following is not a valid access modifier?', 'public', 'private', 'protected', 'internal', 4, 1, 1),
(42, 'Java', 'What is the default value of a boolean variable in Java?', 'true', 'false', '0', 'null', 2, 2, 1),
(43, 'Java', 'Which of the following is not a valid loop in Java?', 'for', 'foreach', 'while', 'do-while', 2, 3, 1),
(44, 'Java', 'What will be the output of System.out.println(5 + 2 + \'Test\');?', '7Test', 'Test7', '5 + 2Test', 'Error', 1, 1, 1),
(45, 'Java', 'What is the correct way to create an object in Java?', 'Class obj = new Class();', 'new Class();', 'Class obj;', 'obj = new Class();', 1, 2, 1),
(46, 'Java', 'Which collection class allows elements to be retrieved in FIFO order?', 'ArrayList', 'Stack', 'Queue', 'HashSet', 3, 3, 1),
(47, 'Java', 'What does the final keyword do when applied to a method?', 'Prevents method overriding', 'Prevents method overloading', 'Makes method static', 'Makes method private', 1, 1, 1),
(48, 'Java', 'Which class is used for file handling in Java?', 'File', 'Files', 'FileHandler', 'FileStream', 1, 2, 1),
(49, 'Java', 'What will 10 % 3 return in Java?', '3', '1', '0', '10', 2, 3, 1),
(50, 'Java', 'Which of these is a valid way to start a thread in Java?', 'new Thread().run();', 'new Thread().start();', 'Thread.run();', 'Thread.start();', 2, 1, 1),
(51, 'Java', 'What does the static keyword mean in Java?', 'Creates multiple instances', 'Belongs to the class', ' not objects', 'Makes variables mutable', 0, 2, 1),
(52, 'Java', 'Which keyword is used to inherit a class in Java?', 'implements', 'extends', 'super', 'this', 2, 3, 1),
(53, 'Java', 'What is the default return type of a constructor?', 'void', 'Object', 'class type', 'null', 3, 1, 1),
(54, 'Java', 'Which of these interfaces provide sorting capability in Java?', 'Comparable', 'Comparator', 'SortUtil', 'Both a and b', 4, 2, 1),
(55, 'Java', 'What is the parent class of Exception and Error in Java?', 'Object', 'Throwable', 'RuntimeException', 'Event', 2, 3, 1),
(56, 'Java', 'Which of these can be used to achieve multiple inheritance in Java?', 'Abstract Class', 'Interfaces', 'Multiple Classes', 'Both a and b', 2, 1, 1),
(57, 'Java', 'Which Java feature allows executing different code blocks based on conditions?', 'Encapsulation', 'Polymorphism', 'Inheritance', 'Conditional Statements', 4, 2, 1),
(58, 'Java', 'Which of these methods is called automatically when an object is created?', 'run()', 'finalize()', 'constructor', 'init()', 3, 3, 1),
(59, 'Java', 'Which keyword is used to prevent a class from being subclassed?', 'private', 'protected', 'static', 'final', 4, 1, 1),
(60, 'Java', 'Which Java keyword is used to refer to the current instance?', 'super', 'this', 'self', 'instance', 2, 2, 1),
(61, 'Java', 'What will be the result of 5 << 2 in Java?', '10', '15', '20', '25', 3, 3, 1),
(62, 'Java', 'Which of these is true for String objects in Java?', 'Mutable', 'Immutable', 'Cannot be created using new', 'None of the above', 2, 1, 1),
(63, 'Java', 'What is the default value of a reference variable in Java?', '0', 'null', 'Garbage Value', 'Undefined', 2, 2, 1),
(64, 'Java', 'Which keyword is used to define a constant in Java?', 'final', 'static', 'const', 'constant', 1, 1, 1),
(65, 'Java', 'What is the superclass of all Java classes?', 'Object', 'Class', 'Base', 'Super', 1, 2, 1),
(66, 'Java', 'Which of these is not a valid Java identifier?', '_valid', '2invalid', '$valid', 'validName', 2, 3, 1),
(67, 'Java', 'Which package is automatically imported in every Java program?', 'java.util', 'java.io', 'java.lang', 'javax.swing', 3, 1, 1),
(68, 'Java', 'Which of these data types can store fractional values?', 'int', 'boolean', 'float', 'byte', 3, 2, 1),
(69, 'Java', 'Which keyword is used for exception handling in Java?', 'try', 'catch', 'throw', 'All of the above', 4, 3, 1),
(70, 'Java', 'What will be the output of System.out.println(3 + 5 * 2)?', '16', '13', '10', '11', 2, 1, 1),
(71, 'Java', 'Which of these is used to take user input in Java?', 'Scanner', 'BufferedReader', 'InputStream', 'All of the above', 4, 2, 1),
(72, 'Java', 'Which operator is used to allocate memory for an object?', 'new', 'alloc', 'malloc', 'create', 1, 3, 1),
(73, 'Java', 'What will be the output of System.out.println(10 == 10)?', 'true', 'false', 'Error', '10', 1, 1, 1),
(74, 'Java', 'Which of these is not a primitive data type?', 'char', 'byte', 'enum', 'double', 3, 2, 1),
(75, 'Java', 'Which method must be implemented by a Java class that implements Runnable?', 'run()', 'start()', 'execute()', 'process()', 1, 3, 1),
(76, 'Java', 'Which keyword is used to inherit a class in Java?', 'extends', 'implements', 'super', 'this', 1, 1, 1),
(77, 'Java', 'Which of the following is not an access modifier?', 'private', 'protected', 'internal', 'public', 3, 2, 1),
(78, 'Java', 'Which method is called when an object is destroyed?', 'finalize()', 'destroy()', 'exit()', 'terminate()', 1, 1, 1),
(79, 'Java', 'Which loop executes at least once in Java?', 'for', 'while', 'do-while', 'foreach', 3, 2, 1),
(80, 'Java', 'Which exception is thrown when an array index is out of bounds?', 'IOException', 'NullPointerException', 'ArrayIndexOutOfBoundsException', 'NumberFormatException', 3, 3, 1),
(81, 'Java', 'Which keyword is used to stop a loop immediately?', 'break', 'continue', 'exit', 'return', 1, 1, 1),
(82, 'Java', 'What is the default size of an int in Java?', '2 bytes', '4 bytes', '8 bytes', '16 bytes', 2, 2, 1),
(83, 'Java', 'Which operator is used for bitwise AND in Java?', '&', '|', '^', '&&', 1, 3, 1),
(84, 'Java', 'Which of these is not a type of constructor in Java?', 'Default', 'Parameterized', 'Static', 'Copy', 3, 1, 1),
(85, 'Java', 'What will be the output of System.out.println(5 | 3)?', '2', '8', '7', '5', 3, 2, 1),
(86, 'Java', 'Which of these is a marker interface in Java?', 'Cloneable', 'Serializable', 'Runnable', 'Both 1 and 2', 4, 3, 1),
(87, 'Java', 'Which collection does not allow duplicate values?', 'List', 'Set', 'Map', 'Queue', 2, 1, 1),
(88, 'Java', 'Which method is used to get the length of an array in Java?', 'length()', 'size()', 'length', 'capacity()', 3, 2, 1),
(89, 'Java', 'Which of these allows method overloading?', 'Different return types', 'Same parameter types', 'Same method names but different parameters', 'None of the above', 3, 3, 1),
(90, 'Java', 'Which class is used to generate random numbers in Java?', 'Random', 'Math', 'SecureRandom', 'NumberGenerator', 1, 1, 1),
(91, 'Java', 'What is the default value of an uninitialized String in Java?', 'null', '', 'Undefined', '0', 1, 2, 1),
(92, 'Java', 'Which method is used to compare two strings in Java?', 'equals()', '==', 'compareTo()', 'Both 1 and 3', 4, 3, 1);

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
(137, 31, 'Python', 'CVB45Y', 'What will be the output of the following code?<br>\\r\\nx = 5.0<br>\\r\\nprint(x == 5)<br>\\r\\n', 'a) True', 'b) False', 'c) 5', '4) Error', 1);

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
(11, 16, 'Python', 130, 'What is the correct syntax to create a function in Python?', 2, 2, 'Correct', '2025-02-01 04:37:03'),
(12, 16, 'Python', 131, 'Which of the following is the correct extension of Python files?', 2, 2, 'Correct', '2025-02-01 04:37:03'),
(13, 16, 'Python', 132, 'What does the len() function do?', 1, 2, 'Incorrect', '2025-02-01 04:37:03'),
(14, 16, 'Python', 133, 'Which keyword is used to define a variable in Python?', 2, 4, 'Incorrect', '2025-02-01 04:37:03'),
(15, 16, 'Python', 134, 'How do you insert a comment in Python code?', 3, 3, 'Correct', '2025-02-01 04:37:03'),
(16, 16, 'Python', 135, 'What is the output of the following code?<br>\\\\r\\\\na = [1, 2, 3, 4, 5]<br>\\\\r\\\\nprint(a[2:4])<br>\\\\r\\\\n', 1, 4, 'Incorrect', '2025-02-01 04:37:03'),
(17, 16, 'Python', 136, 'What will be the output of the following code?<br>print(type(2))', 1, 2, 'Incorrect', '2025-02-01 04:37:03'),
(18, 16, 'Python', 137, 'What will be the output of the following code?<br>\\\\r\\\\nx = 5.0<br>\\\\r\\\\nprint(x == 5)<br>\\\\r\\\\n', 1, 1, 'Correct', '2025-02-01 04:37:03');

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
(2, 16, 'Python', 4);

-- --------------------------------------------------------

--
-- Table structure for table `submenus`
--

CREATE TABLE `submenus` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submenus`
--

INSERT INTO `submenus` (`id`, `menu_id`, `title`, `link`) VALUES
(1, 1, 'Show candidate', 'show_candidate.php'),
(2, 2, 'Show candidate', 'show_candidate.php');

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
-- Indexes for table `menus`
--
ALTER TABLE `menus`
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
-- Indexes for table `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `candidate_personal_details`
--
ALTER TABLE `candidate_personal_details`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exam_type_menu`
--
ALTER TABLE `exam_type_menu`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `question_bank`
--
ALTER TABLE `question_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `question_results`
--
ALTER TABLE `question_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `submenus`
--
ALTER TABLE `submenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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

--
-- Constraints for table `submenus`
--
ALTER TABLE `submenus`
  ADD CONSTRAINT `submenus_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
