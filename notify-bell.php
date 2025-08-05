<a href="notifications">
                <div id="dashboard_nav_menu31a">
                    <i class="fa-solid fa-bell"></i>
                    <?php 
        $applied_query = "select * from notification where candidate_id = '".$_SESSION['candidate_id']."' and status = 'unread' and deleted IS NULL";
    
                      $applied_result = $db -> query($applied_query);
                      $applied_num = mysqli_num_rows($applied_result);

                      if($applied_num)
                      {
        ?>
                    <span><?php echo $applied_num; ?></span>
                    <?php } ?>
                </div>
                </a>