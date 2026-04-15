 
public abstract class Produto
{
    private int id;
    private String nome;
    private String tipo;
    private String cor;
    private String tamanho;
<<<<<<< HEAD
=======
    private int imagemId;
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
    private int stock;
    private double peso;
    private double precoVenda;
    private double precoCusto;
<<<<<<< HEAD
    public Produto(int id, String nome, String tipo, String cor, String tamanho, int stock, double peso, double precoVenda, double precoCusto)
=======
    public Produto(int id, String nome, String tipo, String cor, String tamanho, int imagemId, int stock, double peso, double precoVenda, double precoCusto)
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
    {
        this.id = id;
        this.nome = nome;
        this.tipo = tipo;
        this.cor = cor;
        this.tamanho = tamanho;
<<<<<<< HEAD
=======
        this.imagemId = imagemId;
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
        this.stock = stock;
        this.peso = peso;
        this.precoVenda = precoVenda;
        this.precoCusto = precoCusto;
    }
    
    public String getNome()
    {
        return this.nome;
    }
    
    public void setNome(String nome)
    {
        this.nome = nome;
    }
    
    public String getTipo()
    {
        return this.tipo;
    }
    
    public String getCor()
    {
        return this.cor;
    }
    
    public String getTamanho()
    {
        return this.tamanho;
    }
<<<<<<< HEAD
=======

    public int getImagemId(){return this.imagemId;}
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
    
    public int getStock()
    {
        return this.stock;
    }
    
    public void setStock(int stock)
    {
        this.stock = stock;
    }
    
    public double getPeso()
    {
        return this.peso;
    }
    
    public double getPrecoVenda()
    {
        return this.precoVenda;
    }
    
    public void setPrecoVenda(double precoVenda)
    {
        this.precoVenda = precoVenda;
    }
    
     public double getPrecoCusto()
    {
        return this.precoCusto;
    }
    
<<<<<<< HEAD
    public void setPrecoCusto(double precoVenda)
=======
    public void setPrecoCusto(double precoCusto)
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
    {
        this.precoCusto = precoCusto;
    }
}
