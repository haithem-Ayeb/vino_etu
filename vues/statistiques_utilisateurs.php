<section class="stat">
<?php
    //Transformer le résultat de Json en array 
    $arr = json_decode($data, true);?>
<div>
    <table>
    <caption>Le nombre des nv usagers par mois</caption>
        <thead>
            <tr>
                <th>Mois</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arr as $item) :  ?>
                <tr>
                    <?php $month_name = date('F', mktime(0, 0, 0, $item['MONTH']));?>
                    <td data-column="mois"><span><?php  echo $month_name.' '.$item['year']; ?></span></td>
                    <td data-column="nbre_nv_usagers"><span><?php echo $item['nombreUsers']; ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>   
</div>
<div>
    <table>
       <caption>Les nombres d'usager et de cellier</caption>
        <thead>
            <tr>
                <th>Nombre d'usager</th>
                <th>Nombre de cellier</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach ($nbUsager as $nb): ?>
             <td data-column="nusager"><?php echo $nb;?></td>
            <?php endforeach; ?>
             <?php foreach ($nbCellier as $nb): ?>
             <td data-column="nusager"><?php echo $nb;?></td>
            <?php endforeach; ?>      
        </tbody>
    </table> 
</div>
<div>
    <table >
       <caption>Le nombre de cellier par usager</caption>
        <thead>
            <tr>
                <th>Usager</th>
                <th>Nombre de cellier</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($celUsager as $cU) : ?>
                <tr>
                    <td data-column="usager"><span><?php echo $cU['usager']; ?></span></td>
                    <td data-column="cellnombre"><span><?php echo $cU['nombre']; ?></span></td>   
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table> 
 </div>
</section> 

    