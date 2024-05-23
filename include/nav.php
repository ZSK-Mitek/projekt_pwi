<?php
    global $activePage;
?>

<nav>
    <div>
        <button type="button">
            <span></span>
        </button>
        <div>
            <ul>
                <li>
                    <a <?php if ($activePage === 'home'): echo 'active'; endif; ?> href="./">Strona główna</a>
                </li>
            </ul>
        </div>
    </div>
</nav>