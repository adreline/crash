<div id="modal" class="modal">
    <div class="window">
        <h2><button id="close-modal"><i class="fa-solid fa-xmark"></i></button><?php echo $title; ?></h2>
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
