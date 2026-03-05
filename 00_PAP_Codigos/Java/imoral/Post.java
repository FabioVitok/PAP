public class Post
{
    private int id;
    private Utilizador user;
    private String dtPostagem;
    private String textoPost;   
    private int likeCount;
    public Post(Utilizador user, String dtPostagem, String textoPost)
    {
     this.user = user;
     this.dtPostagem = dtPostagem;
     this.textoPost = textoPost;
     this.likeCount = 0;
    }
    
    public Utilizador getUser()
    {
        return this.user;
    }
    
    public String getDtPostagem()
    {
        return this.dtPostagem;
    }
    
    public String getTextoPost()
    {
        return this.textoPost;
    }
    
    public void setTextoPost(String textoPost)
    {
        this.textoPost = textoPost;
    }
    
    public int getLikeCount()
    {
        return this.likeCount;
    }
   
}
