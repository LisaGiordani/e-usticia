#IMPORT
import tensorflow as tf
import pandas as pd
import keras
from sklearn.utils import shuffle
from keras.callbacks import CSVLogger
from keras.callbacks import EarlyStopping, ModelCheckpoint
from keras.preprocessing import text
from sklearn.preprocessing import LabelEncoder
import numpy as np
from keras import utils
from keras.models import Sequential
from keras.layers import Dense, Activation, Dropout


'''
Permet d'attribuer l'allocation dynamique de mémoire pour éviter les depassements
'''
#apparement le code suivant est nécessaire sur certains setups, on l'utilise donc au cas où
config = tf.compat.v1.ConfigProto()
config.gpu_options.allow_growth = True
session = tf.compat.v1.Session(config=config)

# Lecture de notre dataset
data = pd.read_csv('.\\dataset\\data.txt', sep=',', names=["text", "result"])


# On mélange les données
data = shuffle(data)

# # On vérifie que le dataset est équilibré et que les classes soient bien conformes
# print('DIMENSION DU DATASET')
# print(data.shape)
#
# print('EQUILIBRE DU DATASET')
# print(data['result'].value_counts())


# Definition des jeux de train et test
trainSize = int(len(data) * .8)
print ("Train taille: %d" % trainSize)
print ("Test taille: %d" % (len(data) - trainSize))

trainText = data['text'][:trainSize]
trainResult = data['result'][:trainSize]

testText = data['text'][trainSize:]
testResult = data['result'][trainSize:]

# Fix des hyper parametres
batch_size = 256
epoch = 80
maxWords = 1000

# Transforme le texte vers une matrice de mot et permet de lui donner un indice
tokenize = text.Tokenizer(num_words=maxWords, char_level=False)
tokenize.fit_on_texts(trainText)
xTrain = tokenize.texts_to_matrix(trainText)
xTest = tokenize.texts_to_matrix(testText)

#Définition des labels des prédictions
encoder = LabelEncoder()
encoder.fit(trainResult)
yTrain = encoder.transform(trainResult)
yTest = encoder.transform(testResult)
numClasses = np.max(yTrain) + 1

yTest = utils.to_categorical(yTest, numClasses)
yTrain = utils.to_categorical(yTrain, numClasses)

# # Shape de nos donnees avant entrainement
# print('xTrain shape:', xTrain.shape)
# print('xTest shape:', xTest.shape)
# print('yTrain shape:', yTrain.shape)
# print('yTest shape:', yTest.shape)

# Définition de notre modele
model_H = Sequential()
model_H.add(Dense(512, input_shape=(maxWords,)))
model_H.add(Activation('relu'))
model_H.add(Dropout(0.5))
model_H.add(Dense(numClasses))
model_H.add(Activation('softmax'))

# Compilation du modele
model_H.compile(loss='categorical_crossentropy',optimizer=keras.optimizers.Adamax(lr=0.001, beta_1=0.9, beta_2=0.999, decay=0.0),metrics=['accuracy'])


# Definition des callbacks
##SI VOUS VOULEZ UN SEUL RESEAU (modèle "Simple" qu'on veut mettre à part), commentez les deux lignes suivantes et décommentez les deux d'après, et n'exécutez que les lignes 1 à 98
check = ModelCheckpoint('.\\modelTrained\\model_H.hdf5', monitor='val_loss', verbose=0,save_best_only=True, save_weights_only=False, mode='auto')
csvLogger = CSVLogger('.\\metrics\\log_H.csv', append=False, separator=',')
#check = ModelCheckpoint('.\\modelTrained\\model.hdf5', monitor='val_loss', verbose=0,save_best_only=True, save_weights_only=False, mode='auto')
#csvLogger = CSVLogger('.\\metrics\\log.csv', append=False, separator=',')

# Entrainement du modele
train =  model_H.fit(xTrain, yTrain, epochs=epoch, callbacks = [csvLogger, check], batch_size=batch_size, validation_data=(xTest,yTest))







##MODELE NH (détection du non-harcèlement)

#Inverse de la data
trainResult = trainResult.replace({0:1,1:0})
testResult = testResult.replace({0:1,1:0})
#Définir les labels des nouvelles prédictions
encoder = LabelEncoder()
encoder.fit(trainResult)
yTrain = encoder.transform(trainResult)
yTest = encoder.transform(testResult)
numClasses = np.max(yTrain) + 1

yTest = utils.to_categorical(yTest, numClasses)
yTrain = utils.to_categorical(yTrain, numClasses)


# Définition de notre deuxième modele
model_NH = Sequential()
model_NH.add(Dense(512, input_shape=(maxWords,)))
model_NH.add(Activation('relu'))
model_NH.add(Dropout(0.5))
model_NH.add(Dense(numClasses))
model_NH.add(Activation('softmax'))

# Compilation du modele
model_NH.compile(loss='categorical_crossentropy',optimizer=keras.optimizers.Adamax(lr=0.001, beta_1=0.9, beta_2=0.999, decay=0.0),metrics=['accuracy'])


# Definition des callbacks
check = ModelCheckpoint('.\\modelTrained\\model_NH.hdf5', monitor='val_loss', verbose=0,save_best_only=True, save_weights_only=False, mode='auto')
csvLogger = CSVLogger('.\\metrics\\log_NH.csv', append=False, separator=',')
# Entrainement du modele
train =  model_NH.fit(xTrain, yTrain, epochs=epoch, callbacks = [csvLogger, check], batch_size=batch_size, validation_data=(xTest,yTest))










