public class Calçado extends Produto
{
    private static final String TIPO = "Calçado";
    public Calçado(int id, String nome, String cor, String tamanho, int stock, double peso, double precoVenda, double precoCusto)
    {
        super(id, nome, TIPO, cor, tamanho, stock, peso, precoVenda, precoCusto);
    }
}
