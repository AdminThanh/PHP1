<section class="recently">
    <a href="#trasua"></a>
                <div class="title">
                    <h1>Trà sữa</h1>
                </div>
                <div class="product-recently">
                    <div class="row">
                        <?php
                        $sql = 'select * from product where id_category=1';
                        // $sql = 'select * from category';
                        $productList = executeResult($sql);
                        // $categoryList = executeResult($sql);
                        $index = 1;


                        foreach ($productList as $item) {
                            echo '
                                <div class="col">
                                    <a href="details.php?id=' . $item['id'] . '">
                                        <img class="thumbnail" src="admin/product/' . $item['thumbnail'] . '" alt="">
                                        <div class="title">
                                            <p>' . $item['title'] . '</p>
                                        </div>
                                        <div class="price">
                                            <span>' . number_format($item['price'], 0, ',', '.') . ' VNĐ</span>
                                        </div>
                                        <div class="more">
                                            <div class="star">
                                                <img src="images/icon/icon-star.svg" alt="">
                                                <span>4.6</span>
                                            </div>
                                            <div class="time">
                                                <img src="images/icon/icon-clock.svg" alt="">
                                                <span>15 comment</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                        }
                        ?>
                    </div>
                </div>
            </section>