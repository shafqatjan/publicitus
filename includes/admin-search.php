<form method="post">
                      <a><?php echo $searchHdnMenu;?> <?php echo $userHdnMenu;?> : </a>
                      <input type="text" class="txtin" name="search" id="search">
                      <select class="txtin" name="membertype" id="membertype">
                        <option value="1"><?php echo $serchBy1;?></option>
                        <option value="2"><?php echo $serchBy2;?></option>
                      </select>
                      <input type="submit" class="button" id="btn_search" name="btn_search" value="<?php echo $searchHdnMenu;?>">
 </form>