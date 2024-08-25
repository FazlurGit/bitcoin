import sys
import pandas as pd
import numpy as np
import xgboost as xgb
from sklearn.model_selection import train_test_split
from sklearn.metrics import mean_squared_error
from sklearn.preprocessing import StandardScaler
import joblib

# Load dataset
df = pd.read_csv('resources/python/btc_2015_2024.csv')

# Convert 'date' to datetime and sort the data by date
df['date'] = pd.to_datetime(df['date'])
df.sort_values(by='date', ascending=True, inplace=True)

# Handle missing data if any
df.ffill(inplace=True)

# Select features and target variable
features = [
    'open', 'high', 'low', 'close', 'volume',
    'rsi_7', 'rsi_14', 'cci_7', 'cci_14',
    'sma_50', 'ema_50', 'sma_100', 'ema_100',
    'macd', 'bollinger', 'TrueRange', 'atr_7', 'atr_14'
]
X = df[features]
y = df['next_day_close']

# Normalize/Standardize data
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(X_scaled, y, test_size=0.2, random_state=42)

# Train an XGBoost model
model = xgb.XGBRegressor(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# Test the model and calculate the error
y_pred = model.predict(X_test)
error = np.sqrt(mean_squared_error(y_test, y_pred))
print(f'Root Mean Squared Error: {error}')

# Save the model and scaler
joblib.dump(model, 'resources/python/xgboost_model.pkl')
joblib.dump(scaler, 'resources/python/scaler.pkl')

# Predict future prices based on the model
def predict_price(model, scaler, df_filtered):
    if df_filtered[features].tail(1).empty:
        raise ValueError("No data available for prediction")
    try:
        future_X = scaler.transform(df_filtered[features].tail(1))
        predicted_prices = model.predict(future_X)
        return predicted_prices[-1]
    except Exception as e:
        print(f"Error during prediction: {str(e)}")
        raise

def get_filtered_data(df, buy_date):
    df['date'] = pd.to_datetime(df['date'])
    df_filtered = df[df['date'] <= pd.to_datetime(buy_date)]
    print(f"Filtered data: {df_filtered.head()}")
    return df_filtered

def get_recommendation(deposit_fiat, bitcoin, buy_date):
    df_filtered = get_filtered_data(df, buy_date)
    predicted_price = predict_price(model, scaler, df_filtered)
    last_price = df_filtered['close'].iloc[-1]
    recommendation = ''

    deposit_fiat = float(deposit_fiat)
    bitcoin = float(bitcoin)

    if deposit_fiat > 0 and bitcoin == 0:
        recommendation = 'Buy' if predicted_price < last_price else 'Wait'
    elif deposit_fiat == 0 and bitcoin > 0:
        recommendation = 'Hold' if predicted_price > last_price else 'Sell'
    elif deposit_fiat > 0 and bitcoin > 0:
        if predicted_price > last_price:
            recommendation = 'Buy More'
        elif predicted_price < last_price:
            recommendation = 'Sell'
        else:
            recommendation = 'Hold'
    else:
        recommendation = 'Invalid Input'

    return recommendation

if __name__ == '__main__':
    deposit_fiat = sys.argv[1]
    bitcoin = sys.argv[2]
    buy_date = sys.argv[3]
    recommendation = get_recommendation(deposit_fiat, bitcoin, buy_date)
    print(recommendation)
