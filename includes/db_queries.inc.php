<?php
  function getUserByEmailQuery($email) {
    return "SELECT * FROM employees WHERE email = '$email'";
  }

  function getUserByIdQuery($id) {
    return "SELECT id, name, email, points, country, phone, type FROM employees WHERE id = '$id'";
  }
  
  function registerNewUserQuery($name, $email, $password, $country, $phone, $type) {
    $join_date = date("Y-m-d H:i:s");
    return "INSERT INTO employees (name, email, password, country, phone, type, join_date) VALUES ('$name', '$email', '$password', '$country', '$phone', '$type', '$join_date');";
  }

  function updateUserQuery($name, $email, $country, $phone, $type, $points, $id) {
    return "UPDATE employees SET name = '$name', email = '$email', country = '$country', phone = '$phone', type = '$type', points = '$points' WHERE id = $id;";
  }

  function getAllEmployeesQuery() {
    return "SELECT id, name, email, points, country, phone, type FROM employees;";
  }

  function getEmployeesBySearchQuery($searchTerm) {
    return 'SELECT id, name, email, points, country, phone, type FROM employees WHERE name LIKE "%'.$searchTerm.'%";';
  }

  function deleteAllDailyWorksOfEmployee($empId) {
    return "DELETE FROM daily_work WHERE daily_work.employeesid = '$empId';";
  }

  function deleteAllCommentsOfEmployee($empId) {
    return "DELETE FROM comment WHERE comment.employeesid = '$empId';";
  }

  function deleteAllPostsOfEmployee($empId) {
    return "DELETE FROM post WHERE post.employeesid = '$empId';";
  }

  function deleteAllReportedReportsOfEmployee($empId) {
    return "DELETE FROM report WHERE report.employeesid = '$empId';";
  }

  function deleteAllReportsOfEmployee($empId) {
    return "DELETE FROM report WHERE report.reported_to = '$empId';";
  }

  function deleteAllTaskByOtherOfEmployee($empId) {
    return "DELETE FROM task_by_others WHERE task_by_others.employeesid = '$empId';";
  }

  function deleteAllTaskByOtherOfEmployeeGivenTo($empId) {
    return "DELETE FROM task_by_others WHERE task_by_others.given_to = '$empId';";
  }

  function deleteEmployeeQuery($empId) {
    return "DELETE FROM employees WHERE employees.id = '$empId';";
  }

  function getAllTasksQuery() {
    return "SELECT d.id as 'tid', d.title, d.description, d.time, d.submission_time, d.project_point, d.deadline, e.name,e.id FROM daily_work as d JOIN employees as e ON e.id = d.employeesid;";
  }

  function getAllReportsQuery() {
    return "SELECT r.time, r.id, r.title, r.description, r.feedback_from_reported, r.admin_feedback, e.name, e1.name as 'name2' FROM employees as e JOIN report as r on e.id = r.employeesid JOIN employees as e1 on e1.id = r.reported_to;";
  }

  function postAdminFeedbackOnReportQuery($feedback, $reportId) {
    return "UPDATE report SET admin_feedback='$feedback' WHERE id = '$reportId';";
  }

  function createDailyWorkQuery($title, $description, $deadline, $point, $empId) {
    $time = date("Y-m-d H:i:s");
    return "INSERT INTO daily_work (title, description, time, deadline, project_point, employeesid) VALUES ('$title', '$description', '$time', '$deadline', $point, $empId);";
  }

  function createTaskByOthersQuery($title, $description, $deadline, $point, $empId, $loggedIn_user_id) {
    $time = date("Y-m-d H:i:s");
    return "INSERT INTO task_by_others (title, given_to,  description, time, deadline, points, employeesid) VALUES ('$title', $empId, '$description', '$time', '$deadline', $point, $loggedIn_user_id);";
  }

  function getAllTasksByOthersOfUserQuery($loggedIn_user_id) {
    return "SELECT t.id, t.title, t.description, t.points, t.time, t.deadline, t.submission_time, e.name, t.employeesid FROM task_by_others as t JOIN employees as e on e.id = t.employeesid where t.given_to = $loggedIn_user_id;";
  }

  function getAllTasksByAdminOfUserQuery($loggedIn_user_id) {
    return "SELECT id, title, description, project_point,time, deadline, submission_time FROM daily_work WHERE employeesid = $loggedIn_user_id;";
  }

  function getSubmitTaskByAdminQuery($taskId) {
    $now = date("Y-m-d H:i:s");
    return "UPDATE daily_work SET submission_time = '$now' WHERE id = '$taskId';";
  }

  function getSubmitTaskByOthersQuery($taskId) {
    $now = date("Y-m-d H:i:s");
    return "UPDATE task_by_others SET submission_time = '$now' WHERE id = '$taskId';";
  }

  function getEmployeePointsQuery($empId) {
    return "SELECT points FROM employees WHERE id = '$empId';";
  }

  function getUpdateEmployeePointsQuery($points, $empId) {
    return "UPDATE employees SET points = '$points' WHERE id = '$empId';";
  }

  function getAllReportsOfEmployeeQuery($loggedIn_user_id) {
    return "SELECT * FROM report WHERE reported_to = $loggedIn_user_id;";
  }

  function postReporterFeedbackOnReportQuery($feedback, $reportId) {
    return "UPDATE report SET feedback_from_reported='$feedback' WHERE id = '$reportId';";
  }

  function getCreatePostQuery($title, $category, $content, $loggedIn_user_id) {
    $now = date("Y-m-d H:i:s");
    return "INSERT INTO post(title, category, content, time, employeesid) VALUES('$title', '$category', '$content', '$now', $loggedIn_user_id);";
  }

  function getAllPostsQuery() {
    return "SELECT * FROM post;";
  }

  function getPostByIdQuery($postId) {
    return "SELECT p.title as postTitle, p.category as postCategory,
               p.content as postContent, p.time as postTime,
               c.comment as commentContent, c.time as commentTime,
               e.name as employeesName
               FROM post as p
               LEFT JOIN comment as c
               ON c.postid = p.id
               LEFT JOIN employees as e
               ON e.id = c.employeesid
               WHERE p.id = $postId";
  }

  function getPostBySearchQuery($searchTerm) {
    return 'SELECT * FROM post WHERE title LIKE "%'.$searchTerm.'%";';
  }

  function getCreateComplainQuery($empId, $title, $description, $loggedIn_user_id) {
    $now = date("Y-m-d H:i:s");
    return "INSERT INTO report (reported_to, time, title, description, employeesid) VALUES($empId, '$now', '$title', '$description', $loggedIn_user_id)";
  }

  function getMyPostsQuery($loggedIn_user_id) {
    return "SELECT * FROM post WHERE employeesid = $loggedIn_user_id";
  }

  function getDeleteCommentsOfPostQuery($postId) {
    return "DELETE FROM comment WHERE postid = $postId";
  }

  function getDeletePostQuery($postId) {
    return "DELETE FROM post WHERE id = $postId";
  }

  function getMyComplainsQuery($loggedIn_user_id) {
    return "SELECT * FROM report WHERE employeesid = $loggedIn_user_id";
  }

  function getDeleteComplainQuery($complainId) {
    return "DELETE FROM report WHERE id = $complainId";
  }
?>