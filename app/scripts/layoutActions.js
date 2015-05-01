function mettreEnPageInitiale()
{
    cacherMettreEnMenu();
    makeAlbumsMenu();
    cacherBioArtist("authorBioNO")
}
function cacherMettreEnMenu()
{
    $(".album_view").hide();
    
}
function makeAlbumsMenu()
{
    
}
{
    
}
function montrerAlbum(albumId)
{
    cacherMettreEnMenu();
    $("#"+albumId).show();
}
function montrerBioArtist(artist)
{
    $("#"+artist).show();
}
function cacherBioArtist(artist)
{
    $("#"+artist).hide();
}