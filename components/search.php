<?php if(isset($_SESSION['user'])) : ?>
    <div class="group_search">
        <form action="index.php" method="post">
            <input type="text" name="text_search" placeholder="Pesquisar:">
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>
<?php else : ?>
    <div class="group_search">
    <form>
        <input type="text" name="text_search" placeholder="Pesquisar:" style="cursor: not-allowed; opacity: .15;" disabled>
        <button type="submit" disabled>
            <i class="fa-solid fa-magnifying-glass" style="cursor: not-allowed; opacity: .15;"></i>
        </button>
    </form>
</div>
<?php endif; ?>