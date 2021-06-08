import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import * as citiesData from '../../assets/cities.json';
import { environment } from '../../environments/environment';

@Component({
  selector: 'app-weather-forecast',
  templateUrl: './weather-forecast.component.html',
  styleUrls: ['./weather-forecast.component.css']
})
export class WeatherForecastComponent implements OnInit {

  public citiesAndSates :any = (citiesData as any).default;
  public temp = '--';
  public feelsLike = '--';
  public minTemp = '--';
  public maxTemp = '--';
  public humidity = '--';
  public windSpeed = '--';
  public deg = '--';
  public windGust = '--';
  public error = '';
  public cityName = '';
  public countryName = '';
  public weatherDescription = '';
  public lastUpdatedTime :Date;
  public apiCallTriggered = false;
  public apiURL = '';

  constructor(private http: HttpClient) { 
    this.apiURL = environment.apiUrl;
  }

  ngOnInit(){
    this.fetchData({value: "New York"});
  }

  fetchData(cityName: any) {
    var city = cityName.value;
    return new Promise<any>((resolve, reject) => {
      const promise = this.http.get<any>(`${this.apiURL}weather_info?city=` + city).toPromise();
      promise.then((res: any)=>{
        resolve(res);
        if(res.error != undefined){
          this.resetValues(res.error);
          return false;
        }
        this.error = '';
        this.temp = res.main.temp;
        this.feelsLike = res.main.feels_like;
        this.minTemp = res.main.temp_min;
        this.maxTemp = res.main.temp_max;
        this.humidity = res.main.humidity + '%';
        this.windSpeed = res.wind.speed + ' m/sec';
        this.deg = res.wind.deg;
        this.cityName = res.name + ',';
        this.countryName = res.sys.country;
        this.weatherDescription = res.weather[0].description;
        this.apiCallTriggered = true;
        if (res.nowTime) {
          this.lastUpdatedTime = new Date(res.nowTime*1000);
        }
        else {
          this.lastUpdatedTime = new Date;
        }
        if (res.wind.gust != undefined) {
          this.windGust = res.wind.gust + ' m/sec';
        } 
        else {
          this.windGust = '--';
        } 
      }, (err)=>{
        reject(err);
        this.resetValues("Something went wrong, please try again later");
      })
    });
  }

  resetValues(errorMessage){
    this.temp = '--';
    this.feelsLike = '--';
    this.minTemp = '--';
    this.maxTemp = '--';
    this.humidity = '--';
    this.windSpeed = '--';
    this.deg = '--';
    this.windGust = '--';
    this.apiCallTriggered = false;
    this.error = errorMessage;
  }

}
