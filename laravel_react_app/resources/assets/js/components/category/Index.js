import React, { Component } from 'react';
import {Link,Route} from 'react-router-dom';
import Listing from './Listing';
import Edit from './Edit';
import Add from './Add';

export default class Index extends Component {
    render() {
        return (
            <div>
                <div>
                    <br/>
                    <Link to="/category" className="btn btn-primary">Listing</Link>&nbsp;
                    <Link to="/category/add" className="btn btn-primary">Add</Link>
                    <br/>
                    <Route exact path="/category" component={Listing} />
                    <Route exact path="/category/add" component={Add} />
                    <Route exact path="/category/edit/:id" component={Edit} />
                </div>
            </div>
        );
    }
}

