<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title><?php echo $this->db->get_where('setting', array('name' => 'system_name'))->row()->content; ?> - <?php echo $this->db->get_where('setting', array('name' => 'tagline'))->row()->content; ?> | <?php echo $page_title; ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="<?php echo $this->db->get_where('setting', array('name' => 'tagline'))->row()->content; ?>" name="description" />
    <meta content="bai" name="author" />

    <link rel="icon" type="image/*" href="<?php echo base_url(); ?>uploads/website/<?php echo $this->db->get_where('setting', array('name' => 'favicon'))->row()->content; ?>">

    <?php include 'includes_top.php'; ?>
</head>

<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show">
        <div class="material-loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
            </svg>
            <div class="message">Loading...</div>
        </div>
    </div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar">

        <?php include 'header.php'; ?>
        <?php include 'sidebar.php'; ?>
        <?php include $page_name . '.php'; ?>

        <?php include 'modal.php'; ?>
    </div>
    <!-- end page container -->

    <?php include 'includes_bottom.php'; ?>
    <?php include 'toastr.php'; ?>
</body>

</html>