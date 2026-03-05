public class Comentario
{
    private int id;
    private Utilizador user;
    private Post postPai;
    private int idComentarioPai;
    private String dtComentario;
    private String textoComentario;
    private int likeCount;
    
    public Comentario(Utilizador user, Post postPai, int idComentarioPai, String textoComentario)
    {
        this.user = user;
        this.postPai = postPai;
        this.idComentarioPai = idComentarioPai; // 0 se não houver comentario pai
        this.textoComentario = textoComentario;
    }

    public int getId()
    {
        return this.id;   
    }
    
    public Utilizador getUser()
    {
        return this.user;
    }
    
    public Post getPostPai()
    {
        return this.postPai;
    }
    
    public int getIdComentarioPai()
    {
        return this.idComentarioPai;
    }
    
    public String getDtComentario()
    {
        return this.dtComentario;
    }
    
    public String getTextoComentario()
    {
        return this.textoComentario;
    }
    
    public void setTextoComentario(String textoComentario)
    {
        this.textoComentario = textoComentario;
    }
    
    public int getLikeCount()
    {
        return this.likeCount;
    }
}
