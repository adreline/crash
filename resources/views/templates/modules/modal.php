<div id="modal" class="modal">
    <div class="window">
        <h2 class="title"><?php echo $title; ?><button id="close-modal"><h1>[x]</h1></button></h2>
        <div class="content">
            <p><?php echo $body; ?></p>
        </div>
    </div>
</div>
<script>
document.getElementById("close-modal").addEventListener("click", ()=>{
    document.getElementById("modal").remove();
});
</script>
