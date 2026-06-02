package com.example.imoral.models;
public class Utilizador
{
    private int id;
    private String nome;
    private String email;
    private String image;
    private String role;
    private String telefone;
    private String password;
    private String morada;
    private String dtNascimento;
    
    public Utilizador(int id, String nome, String email, String image, String role, String telefone, String password, String morada, String dtNascimento )
    {
        this.id = id;
        this.nome = nome;
        this.email = email;
        this.image = image;
        this.role = role;
        this.telefone = telefone;
        this.password = password;
        this.morada = morada;
        this.dtNascimento = dtNascimento;
    }

    public int getId()
    {
        return this.id;
    }
    
    public String getUsername()
    {
        return this.nome;
    }
    
    public void setNome(String nome)
    {
        this.nome = nome;
    }
    
    public String getEmail()
    {
        return this.email;
    }
    
    public void setEmail(String email)
    {
        this.email = email;
    }
    
    public String getImage()
    {
        return this.image;
    }
    
    public void setImagemId(String image)
    {
        this.image = image;
    }
    
    public String getRole() 
    {
        return this.role;
    }
    
    public void setRole(String role)
    {
        this.role = role;
    }
    
    public String getTelefone()
    {
        return this.telefone;
    }
    
    public void setTelefone(String telefone)
    {
        this.telefone = telefone;
    }
    
    public String getPassword()
    {
        return this.password;
    }
    
    public void setPassword(String password)
    {
        this.password = password;
    }
    
    public String getMorada()
    {
        return this.morada;
    }
    
    public void setMorada(String password)
    {
        this.morada = morada;
    }
    
    public String getDtNascimento()
    {
        return this.dtNascimento;
    }
    
    public void setDtNascimento(String dt_nascimento)
    {
        this.dtNascimento = dtNascimento;
    }
}
