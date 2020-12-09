import React, { Component } from 'react';
import ReactDOM from 'react-dom';
// Important custom components
import Header from './Header';
import Footer from './Footer';


export default class Index extends Component {
    render() {
        return (
            <div className="container">
                <Header/>
                <Footer/>
            </div>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<Index />, document.getElementById('app'));
}
