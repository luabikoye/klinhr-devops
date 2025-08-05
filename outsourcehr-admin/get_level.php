<?php
ob_start();
session_start();
include("connection/connect.php");
require_once('inc/fns.php');

$salary_band = $_POST['salary_band'];
$client = $_POST['client'];

$query = "select * from settings where band = '$salary_band' and client = '$client'";
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);

$row = mysqli_fetch_array($result);
$select = "select * from salary_band where client = '$client' and band = '$salary_band'";
$rest = mysqli_query($db, $select);
$num = mysqli_num_rows($rest);

$rows = mysqli_fetch_array($rest);


echo '               
<div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Basic Salary
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="basic" id="leave" class="form-control" readonly value=" ' . $row['basic'] . '">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>   
<div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Housing
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="housing" id="leave" class="form-control" readonly value=" ' . $row['housing'] . '">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>   
<div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Transport
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="transport" id="leave" class="form-control" readonly value=" ' . $row['transport'] . '">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>   
<div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Meals & Entertainment
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="meal" id="leave" class="form-control" readonly value=" ' . $row['meals'] . '">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>   
<div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Utility
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="utility" id="leave" class="form-control" readonly value=" ' . $row['utility'] . '">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>   
<div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Leave Allowance
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="leave_allowance" id="leave" class="form-control" readonly value=" ' . $row['leave_allo'] . '">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>';
