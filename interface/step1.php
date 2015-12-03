<?php

    session_start();
    require_once('../util/main.php');
    require_once('header.php');
    require_once('../model/database.php');
    require_once('../model/location_db.php');

    $locations = get_locations();

    $pickupType = '';
    $locationID = '';


    if(!empty($_POST['pickupType'])) {

        if (!isset($_SESSION['order'])) {
            $_SESSION['order'] = array();
        }
        $_SESSION['order']['pickupType'] = $_POST['pickupType'];
        $_SESSION['order']['locationID'] = $_POST['locationID'];

        $pickupType = $_POST['pickupType'];
        $locationID = $_POST['locationID'];
        header("Location:step2.php");
        exit();
    }

    if (isset($_SESSION['order'])) {
        $pickupType = $_SESSION['order']['pickupType'];
        $locationID = $_SESSION['order']['locationID'];
    }
?>

<!-- Page Content -->
<div class="container">
    <div class="back">
        <!-- Section Header -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Select an Order Method</h2>
            </div>
        </div>
        <!-- Items Row -->
        <div class="row">
            <div class="col-md-offset-2 col-md-4 portfolio-item">
                <div class="choiceOuter orderMethod" id="Pickup">
                    <div class="choiceContainer">
                        <div class="choice <?php if($pickupType=='P') echo 'hasBorder';?>">
                            <p class="choiceText">
                                Pick-up
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 portfolio-item">
                <div class="choiceOuter orderMethod" id="Delivery">
                    <div class="choiceContainer">
                        <div class="choice <?php if($pickupType=='D') echo 'hasBorder';?>">
                            <p class="choiceText">
                                Delivery
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Header -->
    <div class="back">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Select a Location</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-2 col-md-4 portfolio-item">
                <div class="choiceOuter location" id="location<?php echo $locations[0]['locationID'];?>">
                    <div class="choiceContainer ">
                        <div class="choice <?php if($locationID==$locations[0]['locationID']) echo 'hasBorder';?>">
                            <p class="choiceText var">
                                <?php echo $locations[0]['name'];?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 portfolio-item">
                <div class="choiceOuter location" id="location<?php echo $locations[1]['locationID'];?>">
                    <div class="choiceContainer">
                        <div class="choice <?php if($locationID==$locations[1]['locationID']) echo 'hasBorder';?>">
                            <p class="choiceText var">
                                <?php echo $locations[1]['name'];?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="step1.php" method="post" id="orderLocationForm">
        <input type="hidden" id="pickupType" name="pickupType" value="<?php echo $pickupType;?>"/>
        <input type="hidden" id="locationID" name="locationID" value="<?php echo $locationID;?>"/>
    </form>


    <!-- Pagination -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="pager">
                <div class="text-right">
                    <li><a href="javascript:void(0);" onclick="$('#orderLocationForm').submit(); return false;">Next</a></li>
                </div>
            </ul>
        </div>
    </div>

    <!-- /.row -->

<?php include 'footer.php'; ?>
<script>
    $(".choiceOuter").click(function(){
        $(this).find(".choice").addClass("hasBorder");
        switch(this.id){
            case "Pickup":
                $('#pickupType').val('P');
                $("#Delivery").find(".choice").removeClass("hasBorder"); break;
            case "Delivery":
                $('#pickupType').val('D');
                $("#Pickup").find(".choice").removeClass("hasBorder"); break;
            case "location<?php echo $locations[0]['locationID'];?>":
                $('#locationID').val(<?php echo $locations[0]['locationID'];?>);
                $("#location<?php echo $locations[1]['locationID'];?>").find(".choice").removeClass("hasBorder"); break;
            case "location<?php echo $locations[1]['locationID'];?>":
                $('#locationID').val(<?php echo $locations[1]['locationID'];?>);
                $("#location<?php echo $locations[0]['locationID'];?>").find(".choice").removeClass("hasBorder"); break;
            default: break;
        }
    });

    $(".location").mouseover(function(){
        $(this).find(".choice p").text(locations[this.id]);
        $(this).find(".choice p").addClass("choiceText2");
        $(this).find(".choice p").removeClass("choiceText");
    });


    $(".location").mouseleave(function(){
        $(this).find(".choice p").text(locationNames[this.id]);
        $(this).find(".choice p").addClass("choiceText");
        $(this).find(".choice p").removeClass("choiceText2");
    });

    locations={};
    locations["location<?php echo $locations[0]['locationID'];?>"]="<?php echo $locations[0]['street'].', '.
                                                                               $locations[0]['city'].', '.
                                                                               $locations[0]['state'].' '.
                                                                               $locations[0]['zipCode'].
                                                                               ' Phone: '.
                                                                               $locations[0]['phone'];?>";

    locations["location<?php echo $locations[1]['locationID'];?>"]="<?php echo $locations[1]['street'].', '.
                                                                               $locations[1]['city'].', '.
                                                                               $locations[1]['state'].' '.
                                                                               $locations[1]['zipCode'].
                                                                               ' Phone: '.
                                                                               $locations[1]['phone'];?>";

    locationNames={};
    locationNames["location<?php echo $locations[0]['locationID'];?>"]="<?php echo $locations[0]['name'];?>";
    locationNames["location<?php echo $locations[1]['locationID'];?>"]="<?php echo $locations[1]['name'];?>";


</script>

