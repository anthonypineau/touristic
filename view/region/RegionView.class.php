<?php
namespace view\region;
use view\GenericView;
use model\work\Region;

/**
 * @author apineau
 * @version 2021
 */
class RegionView extends GenericView {
    private $region;

    public function __construct() {
        parent::__construct();
    }

    public function display() {
        include $this->getHead();
    ?>
        <div class="region">
            <div class="name">
                <h1><?php echo $this->region->getName() ?></h1>
            </div>
            <ul class="cities">
                <?php
                    foreach($this->region->getCities() as $city){
                        ?>
                            <li class="city">
                                <div class="description">
                                    <h2><?php echo $city->getName() ?></h2>
                                    <p><?php echo $city->getDescription() ?></p>
                                </div>
                                <img src="<?php echo $city->getSource() ?>" alt="<?php echo $city->getName() ?>">
                            </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    <?php
        include $this->getFooter();
    }

    public function setRegion(Region $region){
        $this->region = $region;
    }
}