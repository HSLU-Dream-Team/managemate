<?php
	$wikis = $this->get('wikis');
    $wikiHeadlines = $this->get('wikiHeadlines');

    $currentWiki = $this->get('currentWiki');
    $currentArticle = $this->get('currentArticle');


function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1, $tplObject = '') {

    foreach ($array as $headline) {
        if ((int)$currentParent === (int)$headline->parent) {
            if ($currLevel > $prevLevel) echo "
            <ul class='article-toc'> ";
                if ($currLevel == $prevLevel) echo "  ";
                echo '
               <li data-jstree=\'{"icon":"'.$headline->data.'"}\' id="treenode_'.$headline->id.'">&nbsp;<a href="'.BASE_URL.'/wiki/show/'.$headline->id.'">'.$headline->title.'';
                if($headline->status == "draft") {
                    echo" <em>".$tplObject->__('label.draft_parenth')."</em> ";
                }
               echo'</a>';

                if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
                $currLevel++;
                createTreeView ($array, $headline->id, $currLevel, $prevLevel, $tplObject);
                $currLevel--;
                }
                }
                if ($currLevel == $prevLevel) echo "</li>
            </ul>
            ";
            }

?>

<div class="pageheader">
    <div class="pageicon"><span class="fa fa-book"></span></div>
    <div class="pagetitle">

        <h5><?php $this->e($_SESSION["currentProjectClient"]); ?></h5>
        <h1><?php echo $this->__("headlines.documents"); ?></h1>

    </div>

</div>

<div class="maincontent">


        <?php echo $this->displayNotification(); ?>

        <div class="row">

            <div class="col-md-12">
                <div class="maincontentinner">
                    <h2>PM Dashboard</h2>
                    <p>TODO: Change this here</p>

                    <?php
                    echo"<div class='center'>";
                    echo"<div  style='width:30%' class='svgContainer'>";
                    echo file_get_contents(ROOT."/images/svg/undraw_book_reading_re_fu2c.svg");
                    echo"</div>";
                    echo"<br /><h4>".$this->__("headlines.no_articles_yet")."</h4>";


                        echo "".$this->__("text.create_new_wiki")."<br /><br />
                             <a href='".BASE_URL."/wiki/wikiModal/' class='wikiModal inlineEdit btn btn-primary'>".$this->__("link.new_wiki")."</a><br/><br/>";
                    echo"</div>";
                    ?>
                </div>
            </div>


            </div>



        </div>

</div>


<script type="text/javascript">

   jQuery(document).ready(function() {
       <?php if($currentArticle){?>
        leantime.wikiController.initTree("#article-toc-wrapper", <?=$currentArticle->id ?>);
       <?php } ?>

       leantime.wikiController.wikiModal();
       leantime.wikiController.articleModal();

       <?php if($login::userHasRole([$roles::$commenter])) { ?>
        leantime.generalController.enableCommenterForms();
       <?php }?>

    });

</script>
