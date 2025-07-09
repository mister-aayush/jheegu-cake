
  <?php
  include 'db-conn.php';
    $query = "SELECT * FROM menu";
  $stmt =  mysqli_prepare($conn, $query);

  mysqli_execute($stmt);
  $mysqli_result =  mysqli_stmt_get_result($stmt);

  for ($i = 0; $i < mysqli_num_rows($mysqli_result); $i++) {
      $data =  mysqli_fetch_assoc($mysqli_result);
      $datas[] = $data;
  }
  

  ?>
  <!-- Featured Cakes -->
  <section class="max-w-7xl mx-auto px-4 py-12">
    <h3 class="text-2xl font-bold text-center ">Now in display</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php
            if(count($datas)>0):

            
            for ($j = 0; $j < count($datas); $j++):
                $item = $datas[$j];
            ?>
      <!-- Cake Card -->
      <div class="bg-white rounded-2xl shadow p-4 ">
        <img src="http://localhost:8080/Jheegu-Cake/<?php echo $item['image-url']; ?>" alt="Yomari Cake"
          class="rounded-xl mb-4  " />
        <h4 class="text-xl font-semibold text-pink-700"><?php echo $item['item-name']?></h4>
        <p class="text-gray-600 text-sm mt-2"><?php echo $item['description']?>
          <span class="hidden" id="more" > <?php echo $item['price']?></span>
        </p>
      </div>
      <?php endfor;
             else: ?> 

                <p class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                   
                        okk
             </p>
            <?php endif; ?>

      

    </div>
  </section>