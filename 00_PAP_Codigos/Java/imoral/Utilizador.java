 
public class Utilizador
{
    private int id;
    private String nome;
    private String email;
<<<<<<< HEAD
=======
    private String imagem;
    private String role;
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
    private String telefone;
    private String password;
    private String morada;
    private String dtNascimento;
    
<<<<<<< HEAD
    public Utilizador(int id, String nome, String email,String telefone, String password, String morada, String dtNascimento )
=======
    public Utilizador(int id, String nome, String email, String imagem, String role, String telefone, String password, String morada, String dtNascimento )
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
    {
        this.id = id;
        this.nome = nome;
        this.email = email;
<<<<<<< HEAD
=======
        this.imagem = imagem;
        this.role = role;
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
        this.telefone = telefone;
        this.password = password;
        this.morada = morada;
        this.dtNascimento = dtNascimento;
    }

    public int getId()
    {
        return this.id;
    }
    
    public String getNome()
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
    
<<<<<<< HEAD
=======
    public String getImagem()
    {
        return this.imagem;
    }
    
    public void setImagem(String imagem)
    {
        this.imagem = imagem;
    }
    
    public String getRole() 
    {
        return this.role;
    }
    
    public void setRole(String role)
    {
        this.role = role;
    }
    
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
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
