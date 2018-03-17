/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.Image;
import java.awt.image.BufferedImage;
import java.awt.image.WritableRaster;

/**
 *
 * @author Astrid
 */
public class BinaryImage{
    private int[][] matrix;
    
    public BinaryImage(int[][] matrix){
        this.matrix = matrix;
    }
    
    public BinaryImage(int n, int m){
        this.matrix = new int[n][m];
    }
    
    public BinaryImage(BufferedImage fileImage){
        this.matrix = imageToMatrix(fileImage);
    }
    
    public int[][] getMatrix(){
        return matrix;
    }
    
    public void setMatrix(int[][] matrix){
        this.matrix = matrix;
    }
    
    public int[][] imageToMatrix(BufferedImage fileImage) {
        int height = fileImage.getHeight();
        int width = fileImage.getWidth();    
        
        int[][] imageMatrix = new int[height][width];
        
        for (int i = 0; i < height; i++) {
            for (int j = 0; j < width; j++) {
                Color pixel = new Color(fileImage.getRGB(j, i));
                int red = pixel.getRed();
                int blue = pixel.getBlue();
                int green = pixel.getGreen();
                
                int thresholdColor = 256/2;
                int avgColor = (red + blue + green) / 3;
                
                if(avgColor >= thresholdColor){
                    imageMatrix[i][j] = 1;
                }
                else{
                    imageMatrix[i][j] = 0;
                }
                
            }
        }
        return imageMatrix;
    }

    public BufferedImage matrixToImage(int[][] imageMatrix) {
        int height = imageMatrix.length;
        int width = imageMatrix[0].length;

        BufferedImage binaryImage = new BufferedImage(width, height, BufferedImage.TYPE_BYTE_BINARY);
        WritableRaster wr = binaryImage.getRaster();

        for (int i = 0; i < height; i++) {
            for (int j = 0; j < width; j++) {
                wr.setSample(j, i, 0, imageMatrix[i][j]);
            }

        }
        return binaryImage;
    }

    public void resizeImage(int expectedHeight, int expectedWidth) {
        Image tempImage = this.matrixToImage(matrix).getScaledInstance(expectedWidth, expectedHeight, java.awt.Image.SCALE_SMOOTH);
        BufferedImage resizedImage = new BufferedImage(expectedWidth, expectedHeight, BufferedImage.TYPE_BYTE_BINARY);
        
        Graphics2D g = resizedImage.createGraphics();
        g.drawImage(tempImage, 0, 0, null);
        g.dispose();
        
        this.matrix = imageToMatrix(resizedImage);
    }
    
}
