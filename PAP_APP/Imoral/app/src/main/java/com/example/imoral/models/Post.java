package com.example.imoral.models;
import java.io.Serializable;
public class Post implements Serializable {
    private int id;
    private int id_utilizador;
    private String dt_postagem;
    private String texto_post;
    private int like_count;
    private int comment_count;
    private String username;
    private String image;

    // construtor vazio precisa pro Gson)
    public Post() {}

    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public int getId_utilizador() { return id_utilizador; }
    public void setId_utilizador(int id_utilizador) { this.id_utilizador = id_utilizador; }

    public String getDt_postagem() { return dt_postagem; }
    public void setDt_postagem(String dt_postagem) { this.dt_postagem = dt_postagem; }

    public String getTexto_post() { return texto_post; }
    public void setTexto_post(String texto_post) { this.texto_post = texto_post; }

    public int getLike_count() { return like_count; }
    public void setLike_count(int like_count) { this.like_count = like_count; }

    public int getComment_count() { return comment_count; }
    public void setComment_count(int comment_count) { this.comment_count = comment_count; }

    public String getUsername() { return username; }
    public void setUsername(String username) { this.username = username; }

    public String getImage() { return image; }
    public void setImage(String image) { this.image = image; }
}
